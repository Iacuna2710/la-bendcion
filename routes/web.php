<?php

/**
 * Rutas de la plataforma La Bendición
 *
 * Organización:
 *  1. Rutas públicas (catálogo, inicio)
 *  2. Rutas de autenticación personalizada (contraseña temporal)
 *  3. Rutas del cliente (auth + role:cliente,trabajador,admin)
 *  4. Rutas del panel admin/trabajador (prefijo /admin, role:admin,trabajador)
 *  5. Rutas exclusivas del administrador (prefijo /admin, role:admin)
 *
 * Nota: Las rutas de Breeze (login, register, logout, forgot-password, reset-password)
 *       se mantienen intactas en routes/auth.php y no se modifican.
 */

use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------------------------
// Controladores públicos
// ---------------------------------------------------------------------------
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ProductoController;

// ---------------------------------------------------------------------------
// Controladores de autenticación personalizada (contraseña temporal RF-04)
// ---------------------------------------------------------------------------
use App\Http\Controllers\Auth\PasswordTemporalController;

// ---------------------------------------------------------------------------
// Controladores del área de cliente
// ---------------------------------------------------------------------------
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\FacturaController;

// ---------------------------------------------------------------------------
// Controladores del panel administrativo
// ---------------------------------------------------------------------------
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoAdminController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\MetodoPagoController;

// ===========================================================================
// 1. RUTAS PÚBLICAS
// ===========================================================================

// Página de inicio — muestra el catálogo destacado
Route::get('/', [CatalogoController::class, 'index'])->name('inicio');

// Catálogo de productos con paginación y búsqueda (RF-05, RF-06)
Route::get('/catalogo', [CatalogoController::class, 'catalogo'])->name('catalogo.index');

// Detalle de un producto individual (RF-07)
Route::get('/catalogo/{id}', [CatalogoController::class, 'detalle'])->name('catalogo.detalle');

// ===========================================================================
// 2. RUTA DE RESTABLECIMIENTO DE CONTRASEÑA PERSONALIZADA (RF-04)
//    Estas rutas son complementarias a las de Breeze; manejan la
//    contraseña temporal generada desde el panel.
// ===========================================================================
Route::middleware('guest')->group(function () {
    // Formulario para solicitar el correo (pantalla ¿Olvidaste tu contraseña? personalizada)
    Route::get('/olvide-mi-password', [PasswordTemporalController::class, 'mostrarFormulario'])
        ->name('password.temporal.form');

    // Procesar el correo y enviar la contraseña temporal
    Route::post('/olvide-mi-password', [PasswordTemporalController::class, 'enviarPasswordTemporal'])
        ->name('password.temporal.enviar');
});

// Formulario para establecer nueva contraseña (accesible solo con sesión activa)
Route::middleware('auth')->group(function () {
    Route::get('/nueva-password', [PasswordTemporalController::class, 'mostrarFormularioNueva'])
        ->name('password.nueva.form');

    Route::post('/nueva-password', [PasswordTemporalController::class, 'actualizarPassword'])
        ->name('password.nueva.actualizar');
});

// ===========================================================================
// 3. RUTAS DEL ÁREA DE CLIENTE
//    Protegidas con auth + role:cliente,trabajador,admin
//    Los tres roles pueden acceder al área de cliente
// ===========================================================================
Route::middleware(['auth', 'role:cliente,trabajador,admin'])->group(function () {

    // --- Carrito de compras (RF-08, RF-09) ---
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/actualizar/{id_c_item}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/eliminar/{id_c_item}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

    // --- Pedidos (RF-10, RF-11) ---
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/confirmar', [PedidoController::class, 'confirmar'])->name('pedidos.confirmar');
    Route::post('/pedidos/procesar', [PedidoController::class, 'procesar'])->name('pedidos.procesar');
    Route::get('/pedidos/{id_pedido}', [PedidoController::class, 'detalle'])->name('pedidos.detalle');

    // --- Direcciones de entrega (RF-12) ---
    Route::get('/direcciones', [DireccionController::class, 'index'])->name('direcciones.index');
    Route::get('/direcciones/nueva', [DireccionController::class, 'create'])->name('direcciones.create');
    Route::post('/direcciones', [DireccionController::class, 'store'])->name('direcciones.store');
    Route::get('/direcciones/{id_direccion}/editar', [DireccionController::class, 'edit'])->name('direcciones.edit');
    Route::patch('/direcciones/{id_direccion}', [DireccionController::class, 'update'])->name('direcciones.update');
    Route::delete('/direcciones/{id_direccion}', [DireccionController::class, 'destroy'])->name('direcciones.destroy');

    // API interna: selectores en cascada para el formulario de direcciones
    Route::get('/api/cantones/{id_provincia}', [DireccionController::class, 'cantonesPorProvincia'])->name('api.cantones');
    Route::get('/api/distritos/{id_canton}', [DireccionController::class, 'distritosPorCanton'])->name('api.distritos');

    // --- Facturas del cliente ---
    Route::get('/facturas/{id_factura}', [FacturaController::class, 'show'])->name('facturas.show');
});

// ===========================================================================
// 4. RUTAS DEL PANEL ADMIN + TRABAJADOR
//    Prefijo /admin, protegidas con auth + role:admin,trabajador
// ===========================================================================
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,trabajador'])
    ->name('admin.')
    ->group(function () {

        // --- Dashboard ---
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // --- Gestión de productos (RF-13) — resource completo ---
        Route::resource('productos', ProductoAdminController::class)
            ->names('productos')
            ->parameters(['productos' => 'id_producto']);

        // --- Gestión de categorías (RF-14) — resource completo ---
        Route::resource('categorias', CategoriaController::class)
            ->names('categorias')
            ->parameters(['categorias' => 'id_categoria']);

        // --- Gestión de pedidos (RF-16) — resource sin create/store (no se crean desde admin) ---
        Route::resource('pedidos', PedidoAdminController::class)
            ->names('pedidos')
            ->parameters(['pedidos' => 'id_pedido'])
            ->except(['create', 'store']);

        // Ruta adicional: cambiar estado de un pedido y notificar al cliente
        Route::patch('pedidos/{id_pedido}/estado', [PedidoAdminController::class, 'cambiarEstado'])
            ->name('pedidos.estado');
    });

// ===========================================================================
// 5. RUTAS EXCLUSIVAS DEL ADMINISTRADOR
//    Prefijo /admin, protegidas con auth + role:admin
// ===========================================================================
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {

        // --- Gestión de usuarios (RF-15) ---
        Route::resource('usuarios', UserAdminController::class)
            ->names('usuarios')
            ->parameters(['usuarios' => 'id_user']);

        // Activar / desactivar usuario sin eliminarlo
        Route::patch('usuarios/{id_user}/estado', [UserAdminController::class, 'cambiarEstado'])
            ->name('usuarios.estado');

        // Cambiar el rol de un usuario
        Route::patch('usuarios/{id_user}/rol', [UserAdminController::class, 'cambiarRol'])
            ->name('usuarios.rol');

        // --- Gestión de roles ---
        Route::resource('roles', RolController::class)
            ->names('roles')
            ->parameters(['roles' => 'id_roles']);

        // --- Gestión de métodos de pago ---
        Route::resource('metodos-pago', MetodoPagoController::class)
            ->names('metodos-pago')
            ->parameters(['metodos-pago' => 'id_met_pago']);
    });

// ===========================================================================
// Rutas de perfil de Breeze (se conservan sin cambios)
// ===========================================================================
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===========================================================================
// Rutas de autenticación de Breeze (login, register, logout, etc.)
// Se cargan desde routes/auth.php sin modificación alguna.
// ===========================================================================
require __DIR__.'/auth.php';
