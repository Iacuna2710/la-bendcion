<?php

/**
 * Rutas de la plataforma La Bendición
 */

use Illuminate\Support\Facades\Route;

// Controladores públicos
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ProductoController;

// Autenticación personalizada
use App\Http\Controllers\Auth\PasswordTemporalController;

// Área de cliente
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\FacturaController;

// Panel administrativo
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductoAdminController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\PedidoAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\MetodoPagoController;

// 1. RUTAS PÚBLICAS

Route::get('/', [CatalogoController::class, 'index'])->name('inicio');
Route::get('/catalogo', [CatalogoController::class, 'catalogo'])->name('catalogo.index');
Route::get('/catalogo/{id}', [CatalogoController::class, 'detalle'])->name('catalogo.detalle');

// 2. RECUPERACIÓN DE CONTRASEÑA
Route::middleware('guest')->group(function () {
    // Formulario para solicitar el correo (pantalla ¿Olvidaste tu contraseña? personalizada)
    Route::get('/olvide-mi-password', [PasswordTemporalController::class, 'mostrarFormulario'])
        ->name('password.temporal.form');

    Route::post('/olvide-mi-password', [PasswordTemporalController::class, 'enviarPasswordTemporal'])
        ->name('password.temporal.enviar');
});

Route::middleware('auth')->group(function () {
    Route::get('/nueva-password', [PasswordTemporalController::class, 'mostrarFormularioNueva'])
        ->name('password.nueva.form');

    Route::post('/nueva-password', [PasswordTemporalController::class, 'actualizarPassword'])
        ->name('password.nueva.actualizar');
});

// 3. ÁREA DE CLIENTE
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

    Route::get('/facturas/{id_factura}', [FacturaController::class, 'show'])->name('facturas.show');
});

// 4. PANEL ADMIN Y TRABAJADOR
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

        Route::patch('pedidos/{id_pedido}/estado', [PedidoAdminController::class, 'cambiarEstado'])
            ->name('pedidos.estado');
    });

// 5. RUTAS EXCLUSIVAS DEL ADMINISTRADOR
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

// Rutas de Perfil (Breeze)
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Rutas de Autenticación (Breeze)
require __DIR__.'/auth.php';
