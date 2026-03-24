<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra la vista de inicio de sesión.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa la solicitud de inicio de sesión.
     * — Verifica que la cuenta esté activa.
     * — Si la contraseña es temporal, redirige al formulario de cambio.
     * — Redirige al panel correspondiente según el rol del usuario.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentica las credenciales y lanza excepción si son incorrectas
        $request->authenticate();

        $request->session()->regenerate();

        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        // Verificar que la cuenta esté activa (campo is_active)
        if (!$usuario->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Tu cuenta está desactivada. Contacta al administrador.']);
        }

        // Si el usuario inició sesión con una contraseña temporal, forzar el cambio
        if ($usuario->password_es_temporal) {
            return redirect()->route('password.nueva.form');
        }

        // Redirigir al panel correcto según el rol del usuario
        return redirect($this->redirigirSegunRol($usuario));
    }

    /**
     * Cierra sesión del usuario autenticado.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Determina la URL de redirección según el rol del usuario.
     *
     * @param  \App\Models\User  $usuario
     * @return string
     */
    private function redirigirSegunRol($usuario): string
    {
        // Admin y trabajador van al panel administrativo
        if ($usuario->hasAnyRole(['admin', 'trabajador'])) {
            return route('admin.dashboard');
        }

        // Clientes van al catálogo público
        return route('inicio');
    }
}
