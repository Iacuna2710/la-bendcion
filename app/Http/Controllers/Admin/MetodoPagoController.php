<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetodoPago;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * MetodoPagoController
 *
 * Gestión de métodos de pago del sistema (solo administrador).
 */
class MetodoPagoController extends Controller
{
    /**
     * Muestra listado de métodos de pago.
     */
    public function index(): View
    {
        $metodosPago = MetodoPago::orderBy('nombre')->get();
        return view('admin.metodos-pago.index', compact('metodosPago'));
    }

    /**
     * Muestra formulario para crear un nuevo método de pago.
     */
    public function create(): View
    {
        return view('admin.metodos-pago.form');
    }

    /**
     * Guarda un nuevo método de pago.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
        ], [
            'nombre.required' => 'El nombre del método de pago es obligatorio.',
        ]);

        MetodoPago::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.metodos-pago.index')
            ->with('success', 'Método de pago creado correctamente.');
    }

    /**
     * Redirige a la vista de edición.
     */
    public function show(int $id_met_pago): RedirectResponse
    {
        return redirect()->route('admin.metodos-pago.edit', $id_met_pago);
    }

    /**
     * Muestra formulario para editar un método de pago.
     */
    public function edit(int $id_met_pago): View
    {
        $metodo = MetodoPago::findOrFail($id_met_pago);
        return view('admin.metodos-pago.form', compact('metodo'));
    }

    /**
     * Actualiza un método de pago.
     */
    public function update(Request $request, int $id_met_pago): RedirectResponse
    {
        $request->validate([
            'nombre'      => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
        ]);

        $metodo = MetodoPago::findOrFail($id_met_pago);

        $metodo->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.metodos-pago.index')
            ->with('success', "Método «{$metodo->nombre}» actualizado correctamente.");
    }

    /**
     * Elimina un método de pago (desactivación lógica).
     */
    public function destroy(int $id_met_pago): RedirectResponse
    {
        $metodo = MetodoPago::findOrFail($id_met_pago);

        // Eliminación lógica: desactivar en lugar de eliminar
        $metodo->update(['is_active' => false]);

        return redirect()->route('admin.metodos-pago.index')
            ->with('success', "Método «{$metodo->nombre}» desactivado correctamente.");
    }
}
