<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\View\View;

/**
 * DashboardController
 *
 * Muestra panel de control del administrador con KPIs del sistema,
 * alertas de stock bajo y últimos pedidos recientes.
 */
class DashboardController extends Controller
{
    /**
     * Muestra dashboard principal del panel administrativo.
     * Recopila indicadores clave y alertas de stock.
     */
    public function index(): View
    {
        // ── KPIs principales ────────────────────────────────────────────────

        // Total de usuarios activos (no eliminados)
        $totalUsuarios = User::where('is_active', true)->count();

        // Total de productos activos (sin soft delete)
        $totalProductos = Producto::count();

        // Total de categorías activas
        $totalCategorias = Categoria::where('is_active', true)->count();

        // Total de pedidos en el sistema
        $totalPedidos = Pedido::count();

        // Pedidos de hoy
        $pedidosHoy = Pedido::whereDate('created_at', today())->count();

        // ── Alertas de stock bajo ────────────────────────────────────────────
        // Productos cuyo stock está en o por debajo del stock_minimo
        $productosStockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')
            ->with('imagenPrincipal')
            ->orderBy('stock')
            ->get();

        // ── Últimos pedidos ──────────────────────────────────────────────────
        $ultimosPedidos = Pedido::with(['user', 'estadoPedido'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // ── Ingresos del mes actual ──────────────────────────────────────────
        $ingresosMes = Pedido::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalProductos',
            'totalCategorias',
            'totalPedidos',
            'pedidosHoy',
            'productosStockBajo',
            'ultimosPedidos',
            'ingresosMes',
        ));
    }
}
