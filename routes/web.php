<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('clientes', App\Http\Controllers\ClienteController::class);

Route::get('/tipos-documento', [App\Http\Controllers\DocumentoController::class, 'index']);

Route::get('/giros', [App\Http\Controllers\GiroController::class, 'index']);

Route::get('/tipos-contribuyente', [App\Http\Controllers\TipoContribuyenteController::class, 'index']);

Route::get('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'index']);

Route::get('/municipios', [App\Http\Controllers\MunicipioController::class, 'index']);

Route::get('/paises', [App\Http\Controllers\PaisController::class, 'index']);