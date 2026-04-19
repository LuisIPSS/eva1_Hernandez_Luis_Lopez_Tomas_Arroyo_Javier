<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\Clients;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Checkea si la API está funcionando
Route::get('/health', [HealthController::class, 'check']);

// CRUD de clientes

// Crea un cliente
Route::post('create/clients', [Clients::class, 'create']);

// Extrae a todos los clientes
Route::get('read/clients', [Clients::class, 'store']);

// Extrae a un cliente por id
Route::get('readed/clients/{id}', [Clients::class, 'readed']);

// Actualiza un cliente por id
Route::put('update/clients/{id}', [Clients::class, 'update']);

// Elimina un cliente por id
Route::delete('delete/clients/{id}', [Clients::class, 'destroy']);

