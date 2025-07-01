<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando ✅']);
});

// Esta línea genera todas las rutas (GET, POST, PUT, DELETE) para usuarios
Route::apiResource('usuarios', UserController::class);
