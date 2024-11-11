<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/login/{email}', [UsuarioController::class, 'verificaemail']);
Route::get('/login/{email}/{password}', [UsuarioController::class, 'verificaclave']);
Route::post('/login/registrar', [UsuarioController::class, 'registrar']);

Route::resource('/producto', ProductoController::class);
Route::resource('/categoria', CategoriaController::class);

Route::resource('/cliente', ClienteController::class);

Route::post('/venta', [VentaController::class,'store']);
