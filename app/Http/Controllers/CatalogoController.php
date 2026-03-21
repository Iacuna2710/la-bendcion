<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CatalogoController
 *
 * Gestiona las vistas públicas del catálogo de productos (RF-05, RF-06, RF-07).
 * Accesible por visitantes y usuarios autenticados sin restricción de rol.
 */
class CatalogoController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Página de inicio — productos destacados (RF-05)
    // ─────────────────────────────────────────────────────────────────────────

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

    // ─────────────────────────────────────────────────────────────────────────
    // Catálogo completo con filtros y paginación (RF-05, RF-06)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Catálogo completo con búsqueda por nombre y filtro por categoría.
     * Paginación de 12 productos por página.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function catalogo(Request $request): View
    {
        $busqueda   = $request->input('buscar');
        $categoriaSlug = $request->input('categoria');

        // Construir la consulta base
        $query = Producto::with(['imagenPrincipal', 'categorias'])
            ->where('stock', '>', 0);

        // Filtro por búsqueda de texto (RF-06)
        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('descripcion', 'like', "%{$busqueda}%")
                  ->orWhere('ingredientes', 'like', "%{$busqueda}%");
            });
        }

        // Filtro por categoría usando el slug
        if ($categoriaSlug) {
            $query->whereHas('categorias', function ($q) use ($categoriaSlug) {
                $q->where('slug', $categoriaSlug)->where('is_active', true);
            });
        }

        // Ordenar y paginar — mantener filtros en la URL de paginación
        $productos = $query->orderBy('nombre')
            ->paginate(12)
            ->appends([
                'buscar'    => $busqueda,
                'categoria' => $categoriaSlug,
            ]);

        // Categorías para el panel de filtros lateral
        $categorias = Categoria::where('is_active', true)
            ->withCount('productos')
            ->orderBy('nombre')
            ->get();

        // Categoría actualmente seleccionada (para resaltarla en el filtro)
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

    // ─────────────────────────────────────────────────────────────────────────
    // Detalle de un producto (RF-07)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Muestra el detalle completo de un producto: nombre, precio, descripción,
     * ingredientes, beneficios, imágenes y productos relacionados.
     *
     * @param  int  $id  PK del producto
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

        // Productos relacionados: mismas categorías, excluyendo el actual
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
