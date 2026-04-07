<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CambioEstadoPedidoMail;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * PedidoAdminController
 *
 * Gestiona los pedidos desde el panel administrativo.
 */
class PedidoAdminController extends Controller
{
    /**
     * Muestra listado paginado de pedidos con filtros.
     * Usa sp_listar_pedidos_admin.
     */
    public function index(Request $request): View
    {
        $busqueda = $request->input('buscar', '');
        $estado   = (int) $request->input('estado', 0); // 0 = sin filtro de estado
        $perPage  = 20;
        $page     = max(1, (int) $request->input('page', 1));
        $offset   = ($page - 1) * $perPage;

        DB::statement('SET @total_pedidos = 0');

        $filas = DB::select(
            'CALL sp_listar_pedidos_admin(?, ?, ?, ?, @total_pedidos)',
            [
                $busqueda ?: null,
                $estado   ?: null,
                $perPage,
                $offset,
            ]
        );

        $total = (int) DB::select('SELECT @total_pedidos AS total')[0]->total;

        $items = collect($filas)->map(function ($fila) {
            // Objeto user sintético
            $fila->user = (object) [
                'nombre' => $fila->cliente_nombre,
                'email'  => $fila->cliente_email,
                'id_user' => $fila->cliente_id,
            ];

            // Objeto estadoPedido sintético
            $fila->estadoPedido = (object) [
                'id_estado_ped' => $fila->id_estado_ped,
                'nombre'        => $fila->estado_nombre,
                'color'         => $fila->estado_color,
            ];

            // Convertir created_at string → Carbon (para ->format() en la vista)
            $fila->created_at = $fila->created_at
                ? Carbon::parse($fila->created_at)
                : null;

            return $fila;
        });

        $pedidos = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

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

        DB::statement('CALL sp_cambiar_estado_pedido(?, ?)', [
            $id_pedido,
            $request->id_estado_ped,
        ]);

        $pedido->refresh();
        $pedido->load('estadoPedido');

        if ($pedido->user && $pedido->user->email) {
            Mail::to($pedido->user->email)
                ->send(new CambioEstadoPedidoMail($pedido));
        }

        return redirect()->route('admin.pedidos.show', $id_pedido)
            ->with('success', "Estado del pedido {$pedido->num_pedido} actualizado a «{$pedido->estadoPedido->nombre}». Cliente notificado por correo.");
    }
}
