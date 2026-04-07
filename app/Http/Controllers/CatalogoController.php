<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * CatalogoController
 *
 * Gestiona las vistas públicas del catálogo de productos.
 */
class CatalogoController extends Controller
{
    /**
     * Página de inicio con productos destacados y categorías activas.
     * Muestra los productos con es_destacado = true (máximo 8).
     */
    public function index(): View
    {
        // Productos marcados como destacados con su imagen principal
        $productosDestacados = Producto::with(['imagenPrincipal', 'categorias'])
            ->where('es_destacado', true)
            ->where('stock', '>', 0)
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        // Categorías activas con conteo de productos para la sección de navegación
        $categorias = Categoria::where('is_active', true)
            ->withCount('productos')
            ->orderBy('nombre')
            ->get();

        // Últimos productos agregados (novedades)
        $productosNuevos = Producto::with(['imagenPrincipal', 'categorias'])
            ->where('stock', '>', 0)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        return view('catalogo.index', compact('productosDestacados', 'categorias', 'productosNuevos'));
    }

    /**
     * Catálogo completo con búsqueda por nombre y filtro por categoría.
     * Implementa sp_buscar_productos para listado y paginación.
     */
    public function catalogo(Request $request): View
    {
        $busqueda      = $request->input('buscar', '');
        $categoriaSlug = $request->input('categoria', '');
        $perPage       = 12;
        $page          = max(1, (int) $request->input('page', 1));
        $offset        = ($page - 1) * $perPage;

        DB::statement('SET @total_catalogo = 0');

        DB::select(
            'CALL sp_buscar_productos(?, ?, ?, ?, @total_catalogo)',
            [
                $busqueda      ?: null,
                $categoriaSlug ?: null,
                $perPage,
                $offset,
            ]
        );

        $total = (int) DB::select('SELECT @total_catalogo AS total')[0]->total;

        DB::statement('SET @total_catalogo = 0');
        $filas = DB::select(
            'CALL sp_buscar_productos(?, ?, ?, ?, @total_catalogo)',
            [
                $busqueda      ?: null,
                $categoriaSlug ?: null,
                $perPage,
                $offset,
            ]
        );

        $ids = collect($filas)->pluck('id_producto')->unique()->values()->toArray();

        $categoriasPorProducto = [];
        if (!empty($ids)) {
            $cats = DB::select(
                'SELECT pc.id_producto, c.id_categoria, c.nombre, c.slug
                 FROM producto_categoria pc
                 INNER JOIN categorias c ON c.id_categoria = pc.id_categoria
                 WHERE c.is_active = 1
                   AND pc.id_producto IN (' . implode(',', array_fill(0, count($ids), '?')) . ')',
                $ids
            );
            foreach ($cats as $cat) {
                $categoriasPorProducto[$cat->id_producto][] = $cat;
            }
        }

        $items = collect($filas)->map(function ($fila) use ($categoriasPorProducto) {
            $fila->imagenPrincipal = $fila->imagen_url
                ? (object) [
                    'url'      => $fila->imagen_url,
                    'alt_text' => $fila->imagen_alt ?? $fila->nombre,
                ]
                : null;

            $fila->categorias = collect($categoriasPorProducto[$fila->id_producto] ?? []);

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

        $categorias = Categoria::where('is_active', true)
            ->withCount('productos')
            ->orderBy('nombre')
            ->get();

        $categoriaActual = $categoriaSlug
            ? Categoria::where('slug', $categoriaSlug)->first()
            : null;

        return view('catalogo.catalogo', compact(
            'productos',
            'categorias',
            'categoriaActual',
            'busqueda',
        ));
    }

    /**
     * Muestra el detalle completo de un producto.
     */
    public function detalle(int $id): View
    {
        // Cargar el producto con todas sus relaciones
        $producto = Producto::with([
                'imagenes',        // todas las imágenes ordenadas por 'orden'
                'imagenPrincipal',
                'categorias',
            ])
            ->findOrFail($id);

        $categoriasIds = $producto->categorias->pluck('id_categoria');

        $relacionados = Producto::with(['imagenPrincipal'])
            ->whereHas('categorias', function ($q) use ($categoriasIds) {
                $q->whereIn('categorias.id_categoria', $categoriasIds);
            })
            ->where('id_producto', '!=', $producto->id_producto)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('catalogo.detalle', compact('producto', 'relacionados'));
    }
}
