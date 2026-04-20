<?php

use Illuminate\Support\Facades\Route;

// Redirecciones para compatibilidad con llamadas antiguas sin /api
Route::get('/', function () {
    return response()->json(['message' => 'API back-end, use /api endpoints'], 200);
});

Route::get('/hoteles', function () {
    return redirect('/api/hoteles');
});

Route::fallback(function () {
    return response()->json(['message' => 'Ruta no encontrada - use /api'], 404);
});