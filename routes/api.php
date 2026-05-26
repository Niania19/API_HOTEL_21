<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClientePedidoController;
use App\Http\Controllers\TipoHabitacionController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/prueba', function () {
    return response()->json(['funciona' => true]);
});
// Autenticación ADMIN
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Autenticación CLIENTE
Route::post('/cliente/register', [ClienteController::class, 'register']);
Route::post('/cliente/login', [ClienteController::class, 'login']);

// Productos públicos
Route::apiResource('productos', ProductoController::class);

/*
|--------------------------------------------------------------------------
| Rutas protegidas ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth:cliente')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD generales
    Route::apiResource('ciudades', CiudadController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('tipo_habitaciones', TipoHabitacionController::class);
    Route::apiResource('habitaciones', HabitacionController::class);
    Route::apiResource('pagos', PagoController::class);
    
Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{userId}', [OrderController::class, 'index']);
    Route::get('/orders/{userId}/{orderId}', [OrderController::class, 'show']);
    Route::put('/orders/{orderId}/cancel', [OrderController::class, 'cancel']);


    // ADMIN: Gestión de Pedidos/Reservas
    Route::prefix('admin')->group(function () {
        Route::get('/reservas', [ReservaController::class, 'index']);
        Route::get('/reservas/{id}', [ReservaController::class, 'show']);
        Route::delete('/reservas/{id}', [ReservaController::class, 'destroy']);
        Route::get('/clientes/{id_cliente}/pedidos', [ReservaController::class, 'pedidosPorCliente']);
        Route::get('/clientes/{id_cliente}/pedidos/{id_reserva}', [ReservaController::class, 'pedidoDetalleCliente']);
    });
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas CLIENTE
|--------------------------------------------------------------------------
*/
    
    Route::get('/test', function(){
        return response()->json(['mensaje'=>'Laravel funciona']);
    });    
    Route::get('/prueba2', function () {
    return response()->json([
        'ok' => true
    ]);
});

Route::prefix('cliente')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ClienteController::class, 'logout']);
    Route::get('/profile', [ClienteController::class, 'profile']);
    Route::put('/profile', [ClienteController::class, 'updateProfile']);
    Route::put('/password', [ClienteController::class, 'changePassword']);

    // CLIENTE: Gestión de sus propios pedidos
    Route::post('/pedidos', [ClientePedidoController::class, 'store']);
    Route::get('/pedidos', [ClientePedidoController::class, 'index']);
    Route::get('/pedidos/{id}', [ClientePedidoController::class, 'show']);
    Route::delete('/pedidos/{id}', [ClientePedidoController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Ruta de prueba
|--------------------------------------------------------------------------
*/

Route::get('/test', function () {
    return response()->json([
        'mensaje' => 'Laravel funciona'
    ]);
});