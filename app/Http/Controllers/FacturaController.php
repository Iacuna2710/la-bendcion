<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * FacturaController
 *
 * Permite a los clientes consultar sus facturas.
 * Las facturas se generan automáticamente al confirmar el pedido
 * a través del SP sp_generar_factura llamado desde PedidoController.
 * Este controlador solo muestra; no crea ni edita facturas.
 */
class FacturaController extends Controller
{
    /**
     * Muestra el detalle completo de una factura del usuario autenticado.
     * Verifica que la factura pertenezca a un pedido del usuario.
     *
     * @param  int  $id_factura  PK de la factura
     * @return \Illuminate\View\View
     */
    public function show(int $id_factura): View
    {
        $usuario = Auth::user();

        // Cargar la factura con todos sus datos relacionados
        // Verificar que la factura corresponda a un pedido del usuario autenticado
        $factura = Factura::with([
                'pedido.estadoPedido',
                'pedido.direccion.distrito.canton.provincia',
                'pedido.pagos.metodoPago',
                'items.producto',
            ])
            ->whereHas('pedido', function ($query) use ($usuario) {
                // Seguridad: solo puede ver facturas de sus propios pedidos
                $query->where('id_user', $usuario->id_user);
            })
            ->where('id_factura', $id_factura)
            ->firstOrFail();

        return view('facturas.show', compact('factura'));
    }
}
