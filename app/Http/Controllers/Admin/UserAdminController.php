<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * UserAdminController
 *
 * Gestión completa de usuarios desde el panel administrativo (RF-15).
 * Permite crear, ver, editar, cambiar rol, cambiar estado activo/inactivo
 * y hacer eliminación lógica (soft delete) de usuarios.
 */
class UserAdminController extends Controller
{
    /**
     * Muestra listado paginado de usuarios con buscador y filtro por rol.
     */
    public function index(Request $request): View
    {
        $busqueda = $request->input('buscar');
        $rolFiltro = $request->input('rol');

        $usuarios = User::with('roles')
            ->when($busqueda, function ($query, $busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', "%{$busqueda}%")
                      ->orWhere('email', 'like', "%{$busqueda}%");
                });
            })
            ->when($rolFiltro, function ($query, $rolFiltro) {
                $query->whereHas('roles', fn($q) => $q->where('nombre', $rolFiltro));
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->appends(['buscar' => $busqueda, 'rol' => $rolFiltro]);

        $roles = Rol::orderBy('nombre')->get();

        return view('admin.usuarios.index', compact('usuarios', 'roles', 'busqueda', 'rolFiltro'));
    }

    /**
     * Muestra formulario para crear un nuevo usuario desde el admin.
     */
    public function create(): View
    {
        $roles = Rol::orderBy('nombre')->get();
        return view('admin.usuarios.form', compact('roles'));
    }

    /**
     * Valida y crea un nuevo usuario asignándole el rol seleccionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'        => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'telefono'      => ['nullable', 'string', 'max:20'],
            'identificacion'=> ['nullable', 'string', 'max:50'],
            'password'      => ['required', 'confirmed', 'min:8'],
            'id_roles'      => ['required', 'integer', 'exists:roles,id_roles'],
            'is_active'     => ['nullable', 'boolean'],
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.unique'      => 'Este correo ya está registrado.',
            'id_roles.required' => 'Debes asignar un rol al usuario.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $usuario = User::create([
            'nombre'               => $request->nombre,
            'email'                => $request->email,
            'telefono'             => $request->telefono,
            'identificacion'       => $request->identificacion,
            'password'             => Hash::make($request->password),
            'is_active'            => $request->boolean('is_active', true),
            'password_es_temporal' => false,
            'email_verified_at'    => now(),
        ]);

        // Asignar el rol seleccionado
        $usuario->roles()->attach($request->id_roles);

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario «{$usuario->nombre}» creado correctamente.");
    }

    /**
     * Muestra detalle de un usuario.
     *
     * @param  int  $id_user
     */
    public function show(int $id_user): View
    {
        $usuario = User::with(['roles', 'pedidos', 'direcciones'])->findOrFail($id_user);
        $roles   = Rol::orderBy('nombre')->get();
        return view('admin.usuarios.show', compact('usuario', 'roles'));
    }

    /**
     * Muestra formulario para editar un usuario existente.
     *
     * @param  int  $id_user
     */
    public function edit(int $id_user): View
    {
        $usuario = User::with('roles')->findOrFail($id_user);
        $roles   = Rol::orderBy('nombre')->get();
        return view('admin.usuarios.form', compact('usuario', 'roles'));
    }

    /**
     * Valida y actualiza los datos de un usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id_user): RedirectResponse
    {
        $usuario = User::findOrFail($id_user);

        $request->validate([
            'nombre'         => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', "unique:users,email,{$id_user},id_user"],
            'telefono'       => ['nullable', 'string', 'max:20'],
            'identificacion' => ['nullable', 'string', 'max:50'],
            'id_roles'       => ['required', 'integer', 'exists:roles,id_roles'],
            'is_active'      => ['nullable', 'boolean'],
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.unique'      => 'Este correo ya está registrado por otro usuario.',
            'id_roles.required' => 'Debes asignar un rol.',
        ]);

        $usuario->update([
            'nombre'         => $request->nombre,
            'email'          => $request->email,
            'telefono'       => $request->telefono,
            'identificacion' => $request->identificacion,
            'is_active'      => $request->boolean('is_active'),
        ]);

        // Sincronizar rol (un solo rol activo a la vez)
        $usuario->roles()->sync([$request->id_roles]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario «{$usuario->nombre}» actualizado correctamente.");
    }

    /**
     * Eliminación lógica del usuario (soft delete con deleted_at).
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id_user): RedirectResponse
    {
        $usuario = User::findOrFail($id_user);
        $nombre  = $usuario->nombre;

        // No permitir eliminar al propio administrador logueado
        if ($usuario->id_user === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete(); // SoftDelete — pone deleted_at

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario «{$nombre}» eliminado correctamente.");
    }



    /**
     * Activa o desactiva rápidamente un usuario (toggle is_active).
     *
     * @param  int  $id_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cambiarEstado(int $id_user): RedirectResponse
    {
        $usuario = User::findOrFail($id_user);

        if ($usuario->id_user === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario->update(['is_active' => !$usuario->is_active]);

        $estado = $usuario->is_active ? 'activado' : 'desactivado';

        return back()->with('success', "Usuario «{$usuario->nombre}» {$estado} correctamente.");
    }

    /**
     * Cambia rol de un usuario (reemplaza todos los roles actuales).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cambiarRol(Request $request, int $id_user): RedirectResponse
    {
        $request->validate([
            'id_roles' => ['required', 'integer', 'exists:roles,id_roles'],
        ], [
            'id_roles.required' => 'Debes seleccionar un rol.',
        ]);

        $usuario = User::findOrFail($id_user);

        // sync reemplaza todos los roles actuales con el nuevo
        $usuario->roles()->sync([$request->id_roles]);

        $nuevoRol = Rol::find($request->id_roles);

        return back()->with('success', "Rol de «{$usuario->nombre}» cambiado a «{$nuevoRol->nombre}».");
    }
}
