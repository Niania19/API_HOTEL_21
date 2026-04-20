<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TipoHabitacionController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;

/*
|--------------------------------------------------------------------------
| Rutas públicas (SIN autenticación - temporal para pruebas)
|--------------------------------------------------------------------------
*/

// CRUD de autenticación opcional (puede seguir usando register/login si se desea)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// CRUD de Hoteles, Usuarios, Productos y Tareas
Route::apiResource('hoteles', HotelController::class);
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('productos', ProductoController::class);
Route::apiResource('tareas', TareaController::class);

// CRUD para las tablas nuevas
Route::apiResource('ciudades', CiudadController::class);
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('tipo_habitaciones', TipoHabitacionController::class);
Route::apiResource('habitaciones', HabitacionController::class);
Route::apiResource('reservas', ReservaController::class);
Route::apiResource('pagos', PagoController::class);