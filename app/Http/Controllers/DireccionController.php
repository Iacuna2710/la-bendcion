<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Direccion;
use App\Models\Distrito;
use App\Models\Provincia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * DireccionController
 *
 * Gestiona las direcciones de entrega del usuario autenticado.
 * Permite crear, editar, ver y desactivar (eliminación lógica) direcciones.
 * Las eliminaciones nunca son físicas: se usa el campo is_active = false.
 */
class DireccionController extends Controller
{

    /**
     * Muestra todas las direcciones activas del usuario autenticado.
     */
    public function index(): View
    {
        $usuario = Auth::user();

        $direcciones = Direccion::with(['distrito.canton.provincia'])
            ->where('id_user', $usuario->id_user)
            ->where('is_active', true)
            ->orderByDesc('es_principal')
            ->orderByDesc('created_at')
            ->get();

        return view('direcciones.index', compact('direcciones'));
    }

    /**
     * Muestra el formulario para registrar una nueva dirección.
     * Carga las provincias activas para los selectores en cascada.
     */
    public function create(): View
    {
        // Solo provincias activas para el selector inicial
        $provincias = Provincia::where('is_active', true)
            ->orderBy('nombre')
            ->get();

        return view('direcciones.form', compact('provincias'));
    }

    /**
     * Guarda una nueva dirección en la base de datos.
     * Si el usuario marca esta como principal, desactiva las demás.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_provincia'  => ['required', 'integer', 'exists:provincias,id_provincia'],
            'id_canton'     => ['required', 'integer', 'exists:cantones,id_canton'],
            'id_distrito'   => ['required', 'integer', 'exists:distritos,id_distrito'],
            'detalle'       => ['required', 'string', 'max:500'],
            'es_principal'  => ['nullable', 'boolean'],
        ], [
            'id_provincia.required' => 'Debes seleccionar una provincia.',
            'id_canton.required'    => 'Debes seleccionar un cantón.',
            'id_distrito.required'  => 'Debes seleccionar un distrito.',
            'detalle.required'      => 'El detalle de la dirección es obligatorio.',
        ]);

        $usuario      = Auth::user();
        $esPrincipal  = $request->boolean('es_principal');

        // Si esta dirección se marca como principal, quitar la marca a las demás
        if ($esPrincipal) {
            Direccion::where('id_user', $usuario->id_user)
                ->update(['es_principal' => false]);
        }

        Direccion::create([
            'id_user'      => $usuario->id_user,
            'id_distrito'  => $request->id_distrito,
            'es_principal' => $esPrincipal,
            'detalle'      => $request->detalle,
            'is_active'    => true,
        ]);

        return redirect()->route('direcciones.index')
            ->with('success', 'Dirección registrada correctamente.');
    }


    /**
     * Muestra el formulario para editar una dirección existente.
     * Verifica que la dirección pertenezca al usuario autenticado.
     *
     * @param  int  $id_direccion  PK de la dirección
     * @return \Illuminate\View\View
     */
    public function edit(int $id_direccion): View
    {
        $usuario = Auth::user();

        $direccion = Direccion::with(['distrito.canton.provincia'])
            ->where('id_direccion', $id_direccion)
            ->where('id_user', $usuario->id_user)
            ->where('is_active', true)
            ->firstOrFail();

        $provincias = Provincia::where('is_active', true)->orderBy('nombre')->get();

        // Precarga cantones y distritos del registro actual para los selectores
        $cantones  = Canton::where('id_provincia', $direccion->distrito->canton->id_provincia)
            ->where('is_active', true)->orderBy('nombre')->get();

        $distritos = Distrito::where('id_canton', $direccion->distrito->id_canton)
            ->where('is_active', true)->orderBy('nombre')->get();

        return view('direcciones.form', compact('direccion', 'provincias', 'cantones', 'distritos'));
    }

    /**
     * Actualiza los datos de una dirección existente del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_direccion  PK de la dirección
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id_direccion): RedirectResponse
    {
        $request->validate([
            'id_provincia' => ['required', 'integer', 'exists:provincias,id_provincia'],
            'id_canton'    => ['required', 'integer', 'exists:cantones,id_canton'],
            'id_distrito'  => ['required', 'integer', 'exists:distritos,id_distrito'],
            'detalle'      => ['required', 'string', 'max:500'],
            'es_principal' => ['nullable', 'boolean'],
        ], [
            'id_provincia.required' => 'Debes seleccionar una provincia.',
            'id_canton.required'    => 'Debes seleccionar un cantón.',
            'id_distrito.required'  => 'Debes seleccionar un distrito.',
            'detalle.required'      => 'El detalle de la dirección es obligatorio.',
        ]);

        $usuario = Auth::user();

        $direccion = Direccion::where('id_direccion', $id_direccion)
            ->where('id_user', $usuario->id_user)
            ->where('is_active', true)
            ->firstOrFail();

        $esPrincipal = $request->boolean('es_principal');

        // Si se marca como principal, quitar la marca a las demás
        if ($esPrincipal) {
            Direccion::where('id_user', $usuario->id_user)
                ->where('id_direccion', '!=', $id_direccion)
                ->update(['es_principal' => false]);
        }

        $direccion->update([
            'id_distrito'  => $request->id_distrito,
            'es_principal' => $esPrincipal,
            'detalle'      => $request->detalle,
        ]);

        return redirect()->route('direcciones.index')
            ->with('success', 'Dirección actualizada correctamente.');
    }

    /**
     * Desactiva (eliminación lógica) una dirección del usuario.
     * Nunca se elimina físicamente el registro.
     *
     * @param  int  $id_direccion  PK de la dirección
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id_direccion): RedirectResponse
    {
        $usuario = Auth::user();

        $direccion = Direccion::where('id_direccion', $id_direccion)
            ->where('id_user', $usuario->id_user)
            ->firstOrFail();

        // Eliminación lógica: marcar como inactiva
        $direccion->update(['is_active' => false]);

        return redirect()->route('direcciones.index')
            ->with('success', 'Dirección eliminada correctamente.');
    }

    /**
     * Retorna los cantones activos de una provincia en formato JSON.
     * Usado por el JavaScript del formulario para el selector en cascada.
     *
     * @param  int  $id_provincia
     * @return \Illuminate\Http\JsonResponse
     */
    public function cantonesPorProvincia(int $id_provincia)
    {
        $cantones = Canton::where('id_provincia', $id_provincia)
            ->where('is_active', true)
            ->orderBy('nombre')
            ->get(['id_canton', 'nombre']);

        return response()->json($cantones);
    }

    /**
     * Retorna los distritos activos de un cantón en formato JSON.
     * Usado por el JavaScript del formulario para el selector en cascada.
     *
     * @param  int  $id_canton
     * @return \Illuminate\Http\JsonResponse
     */
    public function distritosPorCanton(int $id_canton)
    {
        $distritos = Distrito::where('id_canton', $id_canton)
            ->where('is_active', true)
            ->orderBy('nombre')
            ->get(['id_distrito', 'nombre']);

        return response()->json($distritos);
    }
}
