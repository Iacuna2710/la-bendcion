<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * CategoriaController
 *
 * CRUD completo de categorías para el panel administrativo.
 * El slug se genera automáticamente del nombre si no se proporciona.
 */
class CategoriaController extends Controller
{
    /**
     * Muestra listado paginado de categorías con buscador.
     */
    public function index(Request $request): View
    {
        $busqueda = $request->input('buscar');

        $categorias = Categoria::when($busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'like', "%{$busqueda}%");
            })
            ->withCount('productos')
            ->orderBy('nombre')
            ->paginate(15)
            ->appends(['buscar' => $busqueda]);

        return view('admin.categorias.index', compact('categorias', 'busqueda'));
    }

    /**
     * Muestra formulario para crear una nueva categoría.
     */
    public function create(): View
    {
        return view('admin.categorias.form');
    }

    /**
     * Valida y guarda una nueva categoría.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validarCategoria($request);

        Categoria::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'slug'        => $request->filled('slug')
                                ? Str::slug($request->slug)
                                : Str::slug($request->nombre),
            'imagen'      => $request->imagen,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Redirige a la edición (no hay vista show separada).
     */
    public function show(int $id_categoria): RedirectResponse
    {
        return redirect()->route('admin.categorias.edit', $id_categoria);
    }

    /**
     * Muestra formulario para editar una categoría existente.
     *
     * @param  int  $id_categoria
     */
    public function edit(int $id_categoria): View
    {
        $categoria = Categoria::findOrFail($id_categoria);
        return view('admin.categorias.form', compact('categoria'));
    }

    /**
     * Valida y actualiza una categoría existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_categoria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id_categoria): RedirectResponse
    {
        $this->validarCategoria($request, $id_categoria);

        $categoria = Categoria::findOrFail($id_categoria);

        $categoria->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'slug'        => $request->filled('slug')
                                ? Str::slug($request->slug)
                                : Str::slug($request->nombre),
            'imagen'      => $request->imagen,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.categorias.index')
            ->with('success', "Categoría «{$categoria->nombre}» actualizada correctamente.");
    }

    /**
     * Desactiva (eliminación lógica) una categoría.
     * Solo se desactiva si no tiene productos activos asociados.
     *
     * @param  int  $id_categoria
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id_categoria): RedirectResponse
    {
        $categoria = Categoria::withCount('productos')->findOrFail($id_categoria);

        if ($categoria->productos_count > 0) {
            return back()->with('error', "No se puede eliminar «{$categoria->nombre}» porque tiene {$categoria->productos_count} producto(s) asociado(s).");
        }

        // Eliminación lógica: desactivar la categoría
        $categoria->update(['is_active' => false]);

        return redirect()->route('admin.categorias.index')
            ->with('success', "Categoría «{$categoria->nombre}» desactivada correctamente.");
    }

    /**
     * Valida los campos del formulario de categoría.
     * El slug debe ser único, excluyendo la propia categoría en edición.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|null  $idExcluir
     */
    private function validarCategoria(Request $request, ?int $idExcluir = null): void
    {
        $slugUnico = $idExcluir
            ? "unique:categorias,slug,{$idExcluir},id_categoria"
            : 'unique:categorias,slug';

        $request->validate([
            'nombre'      => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'slug'        => ['nullable', 'string', 'max:120', $slugUnico],
            'imagen'      => ['nullable', 'string', 'max:500'],
            'is_active'   => ['nullable', 'boolean'],
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'slug.unique'     => 'Este slug ya está en uso. Elige uno diferente.',
        ]);
    }
}
