<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CartItem;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * CarritoController
 *
 * Gestiona el carrito de compras persistente del usuario autenticado.
 * Cada usuario tiene exactamente un carrito. Se crea automáticamente
 * al agregar el primer producto si aún no existe.
 *
 * Llama a los procedimientos almacenados:
 *   - sp_agregar_al_carrito(p_id_user, p_id_producto, p_cantidad)
 *   - sp_vaciar_carrito(p_id_carrito)
 */
class CarritoController extends Controller
{
    /**
     * Muestra el contenido actual del carrito del usuario autenticado.
     * Si no tiene carrito, muestra uno vacío.
     */
    public function index(): View
    {
        $usuario = Auth::user();

        // Obtener el carrito con sus ítems y los datos del producto de cada ítem
        $carrito = Carrito::with(['items.producto.imagenes' => function ($query) {
                $query->where('es_principal', true);
            }])
            ->where('id_user', $usuario->id_user)
            ->first();

        return view('carrito.index', compact('carrito'));
    }

    /**
     * Agrega un producto al carrito usando el SP sp_agregar_al_carrito.
     * El SP maneja la lógica de creación del carrito si no existe,
     * y la actualización del ítem si el producto ya está en el carrito.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function agregar(Request $request): RedirectResponse
    {
        // Valida los datos de entrada
        $request->validate([
            'id_producto' => ['required', 'integer', 'exists:productos,id_producto'],
            'cantidad'    => ['required', 'integer', 'min:1', 'max:99'],
        ], [
            'id_producto.required' => 'Debes seleccionar un producto.',
            'id_producto.exists'   => 'El producto no existe.',
            'cantidad.required'    => 'La cantidad es obligatoria.',
            'cantidad.min'         => 'La cantidad mínima es 1.',
            'cantidad.max'         => 'La cantidad máxima por producto es 99.',
        ]);

        $usuario = Auth::user();

        // Verifica que el producto tenga stock suficiente
        $producto = Producto::findOrFail($request->id_producto);
        if ($producto->stock < $request->cantidad) {
            return back()->with('error', "Stock insuficiente. Solo hay {$producto->stock} unidades disponibles.");
        }

        // Llama al procedimiento almacenado sp_agregar_al_carrito
        // Este SP crea el carrito si no existe y actualiza el ítem si ya está
        DB::statement('CALL sp_agregar_al_carrito(?, ?, ?)', [
            $usuario->id_user,
            $request->id_producto,
            $request->cantidad,
        ]);

        return back()->with('success', "«{$producto->nombre}» agregado al carrito correctamente.");
    }

    /**
     * Actualiza la cantidad de un ítem del carrito.
     * Recalcula el subtotal del ítem y los totales del carrito en PHP.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_c_item  PK del ítem del carrito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actualizar(Request $request, int $id_c_item): RedirectResponse
    {
        $request->validate([
            'cantidad' => ['required', 'integer', 'min:1', 'max:99'],
        ], [
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.min'      => 'La cantidad mínima es 1.',
            'cantidad.max'      => 'La cantidad máxima es 99.',
        ]);

        $usuario = Auth::user();

        // Busca el ítem y verifica que pertenece al carrito del usuario autenticado
        $item = CartItem::with('carrito')->findOrFail($id_c_item);

        if ($item->carrito->id_user !== $usuario->id_user) {
            abort(403, 'No puedes modificar este ítem.');
        }

        // Verifica stock disponible
        if ($item->producto->stock < $request->cantidad) {
            return back()->with('error', "Stock insuficiente. Solo hay {$item->producto->stock} unidades disponibles.");
        }

        // Actualiza cantidad y recalcula subtotal del ítem
        $item->update([
            'cantidad' => $request->cantidad,
            'subtotal' => $item->precio_unitario * $request->cantidad,
        ]);

        // Recalcula los totales del carrito
        $this->recalcularCarrito($item->carrito);

        return back()->with('success', 'Carrito actualizado correctamente.');
    }


    /**
     * Elimina un ítem específico del carrito.
     *
     * @param  int  $id_c_item  PK del ítem del carrito
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar(int $id_c_item): RedirectResponse
    {
        $usuario = Auth::user();

        $item = CartItem::with('carrito')->findOrFail($id_c_item);

        // Verifica que el ítem pertenece al carrito del usuario autenticado
        if ($item->carrito->id_user !== $usuario->id_user) {
            abort(403, 'No puedes eliminar este ítem.');
        }

        $carrito = $item->carrito;
        $item->delete();

        // Recalcula los totales del carrito después de la eliminación
        $this->recalcularCarrito($carrito);

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    /**
     * Vacía completamente el carrito del usuario usando el SP sp_vaciar_carrito.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vaciar(): RedirectResponse
    {
        $usuario = Auth::user();

        $carrito = Carrito::where('id_user', $usuario->id_user)->first();

        if ($carrito) {
            // Llama al procedimiento almacenado sp_vaciar_carrito
            DB::statement('CALL sp_vaciar_carrito(?)', [$carrito->id_carrito]);
        }

        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado correctamente.');
    }


    /**
     * Recalcula los campos subtotal y total del carrito en base a sus ítems actuales.
     *
     * @param  \App\Models\Carrito  $carrito
     * @return void
     */
    private function recalcularCarrito(Carrito $carrito): void
    {
        // Recarga los ítems desde la base de datos
        $carrito->load('items');

        $subtotal = $carrito->items->sum('subtotal');

        $carrito->update([
            'subtotal' => $subtotal,
            'total'    => $subtotal - ($carrito->descuento ?? 0),
        ]);
    }
}
