<?php

use App\Http\Controllers\V1\ProductosController;
use App\Http\Controllers\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function () {
    //Prefijo V1, todo lo que este dentro de este grupo se accedera escribiendo v1 en el navegador, es decir /api/v1/*

    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('productos', [ProductosController::class, 'index']);
    Route::get('productos/{id}', [ProductosController::class, 'show']);
    Route::post('buscar_producto', [ProductosController::class, 'busqueda']);
    Route::post('cant_resultados_busqueda', [ProductosController::class, 'cantResultadosBusqueda']);
    Route::post('vender/{id}', [ProductosController::class, 'vender']);
    Route::post('listar_vendidos', [ProductosController::class, 'listaArticulosVendidos']);
    Route::post('ganancia_total', [ProductosController::class, 'gananciaTotal']);
    Route::post('articulos_sin_stock', [ProductosController::class, 'articulosSinStock']);

    Route::group(['middleware' => ['jwt.verify']], function() {
        //Todo lo que este dentro de este grupo requiere verificación de usuario.

        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('get-user', [AuthController::class, 'getUser']);
        Route::post('productos', [ProductosController::class, 'store']);
        Route::put('productos/{id}', [ProductosController::class, 'update']);
        Route::delete('productos/{id}', [ProductosController::class, 'destroy']);
    });
});
