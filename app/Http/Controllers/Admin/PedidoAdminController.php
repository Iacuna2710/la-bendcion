<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CambioEstadoPedidoMail;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * PedidoAdminController
 *
 * Gestiona los pedidos desde el panel administrativo (RF-16).
 * Permite ver, filtrar y actualizar el estado de los pedidos.
 * Al cambiar el estado llama a sp_cambiar_estado_pedido y notifica
 * al cliente por correo electrónico.
 */
class PedidoAdminController extends Controller
{
    /**
     * Muestra listado paginado de pedidos con filtros.
     */
    public function index(Request $request): View
    {
        $busqueda  = $request->input('buscar');
        $estado    = $request->input('estado');

        $pedidos = Pedido::with(['user', 'estadoPedido'])
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('num_pedido', 'like', "%{$busqueda}%")
                      ->orWhereHas('user', fn($q) => $q->where('nombre', 'like', "%{$busqueda}%"));
            })
            ->when($estado, function ($query, $estado) {
                $query->where('id_estado_ped', $estado);
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->appends(['buscar' => $busqueda, 'estado' => $estado]);

        $estados = EstadoPedido::where('is_active', true)->orderBy('orden')->get();

        return view('admin.pedidos.index', compact('pedidos', 'estados', 'busqueda', 'estado'));
    }

    /**
     * Muestra detalle completo de un pedido.
     *
     * @param  int  $id_pedido
     */
    public function show(int $id_pedido): View
    {
        $pedido = Pedido::with([
                'user',
                'estadoPedido',
                'items.producto',
                'direccion.distrito.canton.provincia',
                'pagos.metodoPago',
                'factura',
            ])
            ->findOrFail($id_pedido);

        $estados = EstadoPedido::where('is_active', true)->orderBy('orden')->get();

        return view('admin.pedidos.show', compact('pedido', 'estados'));
    }

    /**
     * Redirige al show (no se usa formulario edit independiente).
     */
    public function edit(int $id_pedido): RedirectResponse
    {
        return redirect()->route('admin.pedidos.show', $id_pedido);
    }

    /**
     * Redirige al show (update lo maneja cambiarEstado).
     */
    public function update(Request $request, int $id_pedido): RedirectResponse
    {
        return redirect()->route('admin.pedidos.show', $id_pedido);
    }

    /**
     * Eliminación lógica (soft delete) de un pedido.
     *
     * @param  int  $id_pedido
     */
    public function destroy(int $id_pedido): RedirectResponse
    {
        $pedido = Pedido::findOrFail($id_pedido);
        $pedido->delete(); // SoftDelete

        return redirect()->route('admin.pedidos.index')
            ->with('success', "Pedido {$pedido->num_pedido} eliminado correctamente.");
    }

    /**
     * Cambia estado de un pedido llamando al SP sp_cambiar_estado_pedido.
     * Después notifica al cliente por correo electrónico con el nuevo estado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_pedido
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cambiarEstado(Request $request, int $id_pedido): RedirectResponse
    {
        $request->validate([
            'id_estado_ped' => ['required', 'integer', 'exists:estados_pedido,id_estado_ped'],
        ], [
            'id_estado_ped.required' => 'Debes seleccionar un estado.',
            'id_estado_ped.exists'   => 'El estado seleccionado no es válido.',
        ]);

        $pedido = Pedido::with(['user', 'estadoPedido'])->findOrFail($id_pedido);

        // Llamar al procedimiento almacenado sp_cambiar_estado_pedido
        DB::statement('CALL sp_cambiar_estado_pedido(?, ?)', [
            $id_pedido,
            $request->id_estado_ped,
        ]);

        // Recargar el pedido para obtener el nuevo estado actualizado por el SP
        $pedido->refresh();
        $pedido->load('estadoPedido');

        // Enviar correo de notificación al cliente
        if ($pedido->user && $pedido->user->email) {
            Mail::to($pedido->user->email)
                ->send(new CambioEstadoPedidoMail($pedido));
        }

        return redirect()->route('admin.pedidos.show', $id_pedido)
            ->with('success', "Estado del pedido {$pedido->num_pedido} actualizado a «{$pedido->estadoPedido->nombre}». Cliente notificado por correo.");
    }
}
