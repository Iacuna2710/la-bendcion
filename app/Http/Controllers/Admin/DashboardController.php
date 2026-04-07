<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * DashboardController
 *
 * Muestra el panel de control del administrador.
 */
class DashboardController extends Controller
{
    /**
     * Muestra dashboard principal del panel administrativo.
     * Recopila KPIs vía SP, alertas de stock y últimos pedidos.
     */
    public function index(): View
    {
        $kpis = DB::select('CALL sp_obtener_dashboard()')[0];

        $totalUsuarios   = $kpis->total_usuarios;
        $totalProductos  = $kpis->total_productos;
        $totalCategorias = $kpis->total_categorias;
        $totalPedidos    = $kpis->total_pedidos;
        $pedidosHoy      = $kpis->pedidos_hoy;
        $ingresosMes     = $kpis->ingresos_mes;

        $productosStockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')
            ->with('imagenPrincipal')
            ->orderBy('stock')
            ->get();

        $ultimosPedidos = Pedido::with(['user', 'estadoPedido'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

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
