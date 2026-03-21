<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Direccion;
use App\Models\Factura;
use App\Models\MetodoPago;
use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * PedidoController
 *
 * Gestiona el proceso de confirmación y consulta de pedidos del cliente.
 *
 * Llama a los procedimientos almacenados:
 *   - sp_confirmar_pedido(p_id_user, p_id_direccion, p_id_met_pago, OUT p_id_pedido, OUT p_num_pedido)
 *   - sp_generar_factura(p_id_pedido, OUT p_id_factura)
 */
class PedidoController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Historial de pedidos del cliente
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Muestra el historial de pedidos del usuario autenticado (RF-11).
     * Ordena por fecha descendente con paginación.
     */
    public function index(): View
    {
        $usuario = Auth::user();

        $pedidos = Pedido::with('estadoPedido')
            ->where('id_user', $usuario->id_user)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Pantalla de confirmación del pedido
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Muestra el formulario de confirmación del pedido (RF-10).
     * Requiere que el carrito tenga al menos un ítem.
     * Carga las direcciones activas del usuario y los métodos de pago activos.
     */
    public function confirmar(): View|RedirectResponse
    {
        $usuario = Auth::user();

        // Verificar que el carrito tenga productos
        $carrito = Carrito::with(['items.producto'])
            ->where('id_user', $usuario->id_user)
            ->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío. Agrega productos antes de confirmar el pedido.');
        }

        // Cargar direcciones activas del usuario con su jerarquía geográfica
        $direcciones = Direccion::with(['distrito.canton.provincia'])
            ->where('id_user', $usuario->id_user)
            ->where('is_active', true)
            ->orderByDesc('es_principal')
            ->get();

        // Cargar métodos de pago activos
        $metodosPago = MetodoPago::where('is_active', true)->get();

        return view('pedidos.confirmar', compact('carrito', 'direcciones', 'metodosPago'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Procesar y confirmar el pedido
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Procesa la confirmación del pedido (RF-10).
     *
     * 1. Valida los datos del formulario.
     * 2. Llama a sp_confirmar_pedido con parámetros OUT usando variables de sesión MySQL.
     *    El SP descuenta el stock, crea el pedido y sus ítems.
     * 3. Llama a sp_generar_factura para crear la factura automáticamente.
     * 4. Redirige al detalle del pedido creado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function procesar(Request $request): RedirectResponse
    {
        $request->validate([
            'id_direccion' => ['required', 'integer', 'exists:direcciones,id_direccion'],
            'id_met_pago'  => ['required', 'integer', 'exists:metodos_pago,id_met_pago'],
        ], [
            'id_direccion.required' => 'Debes seleccionar una dirección de entrega.',
            'id_direccion.exists'   => 'La dirección seleccionada no es válida.',
            'id_met_pago.required'  => 'Debes seleccionar un método de pago.',
            'id_met_pago.exists'    => 'El método de pago seleccionado no es válido.',
        ]);

        $usuario = Auth::user();

        // Verificar que la dirección pertenece al usuario autenticado
        $direccion = Direccion::where('id_direccion', $request->id_direccion)
            ->where('id_user', $usuario->id_user)
            ->where('is_active', true)
            ->first();

        if (!$direccion) {
            return back()->with('error', 'La dirección seleccionada no es válida.');
        }

        // Verificar que el carrito no esté vacío
        $carrito = Carrito::with('items')
            ->where('id_user', $usuario->id_user)
            ->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return redirect()->route('carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        // ── Llamar a sp_confirmar_pedido con parámetros OUT ──────────────────
        // El SP crea el pedido, descuenta el stock y vacía el carrito.
        // Se usan variables de sesión MySQL para capturar los parámetros OUT.
        DB::statement('CALL sp_confirmar_pedido(?, ?, ?, @id_pedido, @num_pedido)', [
            $usuario->id_user,
            $request->id_direccion,
            $request->id_met_pago,
        ]);

        // Recuperar los valores de los parámetros OUT desde MySQL
        $resultado = DB::select('SELECT @id_pedido as id_pedido, @num_pedido as num_pedido')[0];

        $idPedido  = $resultado->id_pedido;
        $numPedido = $resultado->num_pedido;

        // Verificar que el SP haya creado el pedido correctamente
        if (!$idPedido) {
            return back()->with('error', 'Ocurrió un error al procesar tu pedido. Intenta nuevamente.');
        }

        // ── Llamar a sp_generar_factura con parámetro OUT ─────────────────────
        // El SP crea automáticamente la factura y sus ítems.
        DB::statement('CALL sp_generar_factura(?, @id_factura)', [$idPedido]);
        $resultadoFactura = DB::select('SELECT @id_factura as id_factura')[0];

        // Redirigir al detalle del pedido con mensaje de éxito
        return redirect()->route('pedidos.detalle', $idPedido)
            ->with('success', "¡Pedido {$numPedido} confirmado exitosamente! Tu factura ha sido generada.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Detalle de un pedido
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Muestra el detalle completo de un pedido del usuario autenticado (RF-11).
     * Incluye ítems, estado, dirección, pagos y factura.
     *
     * @param  int  $id_pedido  PK del pedido
     * @return \Illuminate\View\View
     */
    public function detalle(int $id_pedido): View
    {
        $usuario = Auth::user();

        // Buscar el pedido verificando que pertenece al usuario autenticado
        $pedido = Pedido::with([
                'estadoPedido',
                'items.producto',
                'direccion.distrito.canton.provincia',
                'pagos.metodoPago',
                'factura',
            ])
            ->where('id_pedido', $id_pedido)
            ->where('id_user', $usuario->id_user)
            ->firstOrFail();

        return view('pedidos.detalle', compact('pedido'));
    }
}
