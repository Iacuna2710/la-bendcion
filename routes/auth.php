<?php

/**
 * Rutas de autenticación — La Bendición
 *
 * Se conservan únicamente las rutas de inicio de sesión, registro y
 * cierre de sesión. El flujo de recuperación de contraseña se maneja de
 * forma personalizada en web.php a través de PasswordTemporalController.
 */

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// ── Rutas para visitantes no autenticados ──────────────────────────────────
Route::middleware('guest')->group(function () {

    // Formulario de registro
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Formulario de inicio de sesión
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// ── Rutas para usuarios autenticados ──────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Cierre de sesión
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
