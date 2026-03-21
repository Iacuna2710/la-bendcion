<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * RolController
 *
 * Gestión de roles del sistema (solo administrador).
 */
class RolController extends Controller
{
    public function index(): View
    {
        $roles = Rol::withCount('users')->orderBy('nombre')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('admin.roles.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:50', 'unique:roles,nombre'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique'   => 'Ya existe un rol con ese nombre.',
        ]);

        Rol::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', "Rol «{$request->nombre}» creado correctamente.");
    }

    public function show(int $id_roles): RedirectResponse
    {
        return redirect()->route('admin.roles.edit', $id_roles);
    }

    public function edit(int $id_roles): View
    {
        $rol = Rol::findOrFail($id_roles);
        return view('admin.roles.form', compact('rol'));
    }

    public function update(Request $request, int $id_roles): RedirectResponse
    {
        $rol = Rol::findOrFail($id_roles);

        $request->validate([
            'nombre'      => ['required', 'string', 'max:50', "unique:roles,nombre,{$id_roles},id_roles"],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique'   => 'Ya existe un rol con ese nombre.',
        ]);

        $rol->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', "Rol «{$rol->nombre}» actualizado correctamente.");
    }

    public function destroy(int $id_roles): RedirectResponse
    {
        $rol = Rol::withCount('users')->findOrFail($id_roles);

        // No eliminar roles que tienen usuarios asignados
        if ($rol->users_count > 0) {
            return back()->with('error', "No se puede eliminar el rol «{$rol->nombre}» porque tiene {$rol->users_count} usuario(s) asignado(s).");
        }

        $nombre = $rol->nombre;
        $rol->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', "Rol «{$nombre}» eliminado correctamente.");
    }
}
