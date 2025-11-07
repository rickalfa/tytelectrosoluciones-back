<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactoController; // <-- 1. Importamos el controlador



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






// Ruta para recibir los datos del formulario de contacto
Route::post('/contacto', [ContactoController::class, 'store']);

// Ruta para que el usuario verifique su email al hacer clic en el enlace
Route::get('/verificar-email/{token}', [ContactoController::class, 'verify'])->name('verification.verify');




