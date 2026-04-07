<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * ProductoAdminController
 *
 * CRUD completo de productos para el panel administrativo.
 */
class ProductoAdminController extends Controller
{
    /**
     * Muestra listado paginado de productos con buscador.
     * Usa sp_listar_productos_admin.
     */
    public function index(Request $request): View
    {
        $busqueda = $request->input('buscar', '');
        $perPage  = 15;
        $page     = max(1, (int) $request->input('page', 1));
        $offset   = ($page - 1) * $perPage;

        DB::statement('SET @total_prod = 0');

        $filas = DB::select(
            'CALL sp_listar_productos_admin(?, ?, ?, @total_prod)',
            [
                $busqueda ?: null,
                $perPage,
                $offset,
            ]
        );

        $total = (int) DB::select('SELECT @total_prod AS total')[0]->total;

        $items = collect($filas)->map(function ($fila) {
            $fila->imagenPrincipal = $fila->imagen_url
                ? (object) [
                    'url'      => $fila->imagen_url,
                    'alt_text' => $fila->imagen_alt ?? $fila->nombre,
                ]
                : null;

            return $fila;
        });

        $productos = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        $productosStockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')->count();

        return view('admin.productos.index', compact('productos', 'busqueda', 'productosStockBajo'));
    }

    /**
     * Muestra formulario para crear un nuevo producto.
     */
    public function create(): View
    {
        $categorias = Categoria::where('is_active', true)->orderBy('nombre')->get();
        return view('admin.productos.form', compact('categorias'));
    }

    /**
     * Valida y guarda un nuevo producto con sus categorías e imágenes.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validarProducto($request);

        $producto = Producto::create([
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'precio'       => $request->precio,
            'stock'        => $request->stock,
            'stock_minimo' => $request->stock_minimo,
            'sku'          => $request->sku,
            'ingredientes' => $request->ingredientes,
            'beneficios'   => $request->beneficios,
            'es_destacado' => $request->boolean('es_destacado'),
        ]);

        // Asociar categorías seleccionadas
        if ($request->filled('categorias')) {
            $producto->categorias()->sync($request->categorias);
        }

        // Guardar imágenes subidas
        if ($request->hasFile('imagenes')) {
            $this->guardarImagenes($producto, $request->file('imagenes'));
        }

        return redirect()->route('admin.productos.index')
            ->with('success', "Producto «{$producto->nombre}» creado correctamente.");
    }

    /**
     * Redirige al formulario de edición (show no tiene vista propia).
     */
    public function show(int $id_producto): RedirectResponse
    {
        return redirect()->route('admin.productos.edit', $id_producto);
    }

    /**
     * Muestra formulario para editar un producto existente.
     */
    public function edit(int $id_producto): View
    {
        $producto   = Producto::with(['categorias', 'imagenes'])->findOrFail($id_producto);
        $categorias = Categoria::where('is_active', true)->orderBy('nombre')->get();

        // IDs de categorías actualmente asignadas al producto
        $categoriasSeleccionadas = $producto->categorias->pluck('id_categoria')->toArray();

        return view('admin.productos.form', compact('producto', 'categorias', 'categoriasSeleccionadas'));
    }

    /**
     * Valida y actualiza los datos de un producto existente.
     */
    public function update(Request $request, int $id_producto): RedirectResponse
    {
        $this->validarProducto($request, $id_producto);

        $producto = Producto::findOrFail($id_producto);

        $producto->update([
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'precio'       => $request->precio,
            'stock'        => $request->stock,
            'stock_minimo' => $request->stock_minimo,
            'sku'          => $request->sku,
            'ingredientes' => $request->ingredientes,
            'beneficios'   => $request->beneficios,
            'es_destacado' => $request->boolean('es_destacado'),
        ]);

        // Sincronizar categorías (reemplaza las anteriores)
        $producto->categorias()->sync($request->categorias ?? []);

        // Agregar nuevas imágenes si se subieron
        if ($request->hasFile('imagenes')) {
            $this->guardarImagenes($producto, $request->file('imagenes'));
        }

        // Eliminar imágenes marcadas para borrar
        if ($request->filled('eliminar_imagenes')) {
            foreach ($request->eliminar_imagenes as $idImg) {
                $imagen = ImagenProducto::find($idImg);
                if ($imagen && $imagen->id_producto === $producto->id_producto) {
                    if (Storage::disk('public')->exists($imagen->url)) {
                        Storage::disk('public')->delete($imagen->url);
                    }
                    $imagen->delete();
                }
            }
        }

        // Marcar imagen principal si se especificó
        if ($request->filled('imagen_principal')) {
            ImagenProducto::where('id_producto', $producto->id_producto)
                ->update(['es_principal' => false]);
            ImagenProducto::find($request->imagen_principal)
                ?->update(['es_principal' => true]);
        }

        return redirect()->route('admin.productos.index')
            ->with('success', "Producto «{$producto->nombre}» actualizado correctamente.");
    }

    /**
     * Realiza la eliminación lógica de un producto.
     */
    public function destroy(int $id_producto): RedirectResponse
    {
        $producto = Producto::findOrFail($id_producto);
        $nombre   = $producto->nombre;

        $producto->delete(); // SoftDelete: pone deleted_at

        return redirect()->route('admin.productos.index')
            ->with('success', "Producto «{$nombre}» eliminado correctamente.");
    }

    /**
     * Valida los campos del formulario de producto.
     */
    private function validarProducto(Request $request, ?int $idExcluir = null): void
    {
        $skuUnico = $idExcluir
            ? "unique:productos,sku,{$idExcluir},id_producto"
            : 'unique:productos,sku';

        $request->validate([
            'nombre'       => ['required', 'string', 'max:200'],
            'descripcion'  => ['nullable', 'string'],
            'precio'       => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'sku'          => ['nullable', 'string', 'max:100', $skuUnico],
            'ingredientes' => ['nullable', 'string'],
            'beneficios'   => ['nullable', 'string'],
            'es_destacado' => ['nullable', 'boolean'],
            'categorias'   => ['nullable', 'array'],
            'categorias.*' => ['integer', 'exists:categorias,id_categoria'],
            'imagenes'     => ['nullable', 'array'],
            'imagenes.*'   => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nombre.required'       => 'El nombre del producto es obligatorio.',
            'precio.required'       => 'El precio es obligatorio.',
            'precio.min'            => 'El precio no puede ser negativo.',
            'stock.required'        => 'El stock es obligatorio.',
            'stock_minimo.required' => 'El stock mínimo es obligatorio.',
            'imagenes.*.image'      => 'Solo se permiten archivos de imagen.',
            'imagenes.*.max'        => 'Cada imagen no puede superar los 2 MB.',
        ]);
    }

    /**
     * Guarda las imágenes subidas y las registra en imagenes_productos.
     */
    private function guardarImagenes(Producto $producto, array $archivos): void
    {
        $tienePrincipal = ImagenProducto::where('id_producto', $producto->id_producto)
            ->where('es_principal', true)
            ->exists();

        $orden = ImagenProducto::where('id_producto', $producto->id_producto)->max('orden') ?? 0;

        foreach ($archivos as $index => $archivo) {
            $orden++;
            $ruta = $archivo->store('productos', 'public');

            ImagenProducto::create([
                'id_producto'  => $producto->id_producto,
                'url'          => $ruta,
                'alt_text'     => $producto->nombre,
                'orden'        => $orden,
                'es_principal' => (!$tienePrincipal && $index === 0),
            ]);

            if (!$tienePrincipal && $index === 0) {
                $tienePrincipal = true;
            }
        }
    }
}
