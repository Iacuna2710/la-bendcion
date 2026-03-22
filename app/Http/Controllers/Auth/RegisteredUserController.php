<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Muestra formulario de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa registro de un nuevo usuario.
     * Crea el usuario con los campos personalizados de la tabla `users`.
     * Asigna automáticamente el rol 'cliente'.
     * Verifica el correo inmediatamente (sin flujo de verificación por email).
     * Inicia sesión y redirige al catálogo.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los campos del formulario de registro
        $request->validate([
            'nombre'   => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->letters()->numbers()],
        ], [
            'nombre.required'    => 'El nombre completo es obligatorio.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'Ingresa un correo electrónico válido.',
            'email.unique'       => 'Este correo ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crear el usuario con los campos de nuestra tabla personalizada
        $usuario = User::create([
            'nombre'               => $request->nombre,
            'email'                => $request->email,
            'telefono'             => $request->telefono,
            'password'             => Hash::make($request->password),
            'is_active'            => true,
            'password_es_temporal' => false,
            // Marcar email como verificado (sin flujo de verificación adicional)
            'email_verified_at'    => now(),
        ]);

        // Asignar automáticamente el rol 'cliente' al nuevo usuario
        $rolCliente = Rol::where('nombre', 'cliente')->first();
        if ($rolCliente) {
            $usuario->roles()->attach($rolCliente->id_roles);
        }

        // Disparar el evento Registered (usado por Breeze para notificaciones internas)
        event(new Registered($usuario));

        // Iniciar sesión automáticamente
        Auth::login($usuario);

        // Los nuevos clientes van al catálogo después de registrarse
        return redirect()->route('inicio');
    }
}
