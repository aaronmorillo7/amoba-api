<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// rutas de la api, guardar, mostrar todas, actualizar, 
Route::post('user/guardar', [AuthController::class, 'store'])->name('user.store');
Route::get('user', [AuthController::class, 'show'])->name('user.show');
Route::post('user/actualizar', [AuthController::class, 'update'])->name('user.update');
Route::delete('user/borrar/{id}', [AuthController::class, 'delete'])->name('user.delete');

