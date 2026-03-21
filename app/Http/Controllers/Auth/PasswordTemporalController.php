<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordTemporalMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * PasswordTemporalController
 *
 * Maneja el flujo completo de restablecimiento de contraseña mediante
 * contraseña temporal (RF-04):
 *
 *  1. mostrarFormulario()         → vista para que el usuario ingrese su correo
 *  2. enviarPasswordTemporal()    → genera la contraseña temporal y la envía por email
 *  3. mostrarFormularioNueva()    → vista para ingresar la nueva contraseña permanente
 *  4. actualizarPassword()        → guarda la nueva contraseña y redirige según rol
 */
class PasswordTemporalController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Paso 1 — Mostrar formulario para solicitar el correo
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Muestra el formulario donde el usuario ingresa su correo electrónico
     * para solicitar una contraseña temporal.
     */
    public function mostrarFormulario(): View
    {
        return view('auth.forgot-password-custom');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Paso 2 — Generar contraseña temporal y enviarla por email
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Procesa el correo ingresado, genera una contraseña temporal alfanumérica
     * mínima de 8 caracteres y la envía al usuario por SMTP.
     *
     * Por seguridad, siempre se muestra el mismo mensaje genérico
     * independientemente de si el correo existe o no.
     */
    public function enviarPasswordTemporal(Request $request): RedirectResponse
    {
        // Validar que el correo tenga formato válido
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email'    => 'Ingresa un correo electrónico válido.',
        ]);

        // Buscar el usuario en la base de datos
        $usuario = User::where('email', $request->email)->first();

        // Por seguridad no revelamos si el correo existe o no
        if ($usuario) {
            // Generar contraseña temporal alfanumérica de 10 caracteres
            $passwordTemporal = Str::random(10);

            // Actualizar el usuario: hashear la contraseña temporal y marcar el flag
            $usuario->update([
                'password'             => Hash::make($passwordTemporal),
                'password_es_temporal' => true,
            ]);

            // Enviar la contraseña temporal por correo electrónico (SMTP)
            Mail::to($usuario->email)->send(new PasswordTemporalMail($usuario, $passwordTemporal));
        }

        // Mensaje genérico independiente del resultado (seguridad)
        return back()->with('status', 'Si tu correo está registrado recibirás las instrucciones en breve.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Paso 3 — Mostrar formulario para establecer la nueva contraseña
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Muestra el formulario para que el usuario ingrese su nueva contraseña
     * permanente. Solo accesible con sesión activa y password_es_temporal = true.
     */
    public function mostrarFormularioNueva(): View|RedirectResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        // Si no tiene contraseña temporal, redirigir al inicio según su rol
        if (!$usuario || !$usuario->password_es_temporal) {
            return redirect()->route('inicio');
        }

        return view('auth.nueva-password');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Paso 4 — Guardar la nueva contraseña permanente
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Valida y guarda la nueva contraseña permanente del usuario.
     * Requiere: mínimo 8 caracteres, al menos una mayúscula y un número.
     * Al finalizar redirige al panel correspondiente según el rol del usuario.
     */
    public function actualizarPassword(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        // Verificar que el usuario esté en el flujo de contraseña temporal
        if (!$usuario || !$usuario->password_es_temporal) {
            return redirect()->route('inicio');
        }

        // Validar la nueva contraseña: mínimo 8 caracteres, una mayúscula, un número
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',    // al menos una mayúscula
                'regex:/[0-9]/',    // al menos un número
            ],
        ], [
            'password.required'  => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex'     => 'La contraseña debe contener al menos una mayúscula y un número.',
        ]);

        // Guardar la nueva contraseña y desactivar el flag de contraseña temporal
        $usuario->update([
            'password'             => Hash::make($request->password),
            'password_es_temporal' => false,
        ]);

        // Redirigir al panel correspondiente según el rol
        if ($usuario->hasAnyRole(['admin', 'trabajador'])) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Contraseña actualizada correctamente. Bienvenido.');
        }

        return redirect()->route('inicio')
            ->with('success', 'Contraseña actualizada correctamente. Bienvenido.');
    }
}
