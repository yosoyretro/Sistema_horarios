<?php

use App\Http\Controllers\TituloAcademicoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(
    [
        "prefix" => "v1/horario/",
    ],function(){
        Route::post("crear_titulo_academico/",[TituloAcademicoController::class,'createTituloAcademico']);
        Route::post("update_titulo_academico/",[TituloAcademicoController::class,'updateTituloAcademico']);
        Route::post("delete_titulo_academico/",[TituloAcademicoController::class,'deleteTituloAcademico']);
        Route::get("show_data/",[TituloAcademicoController::class,'showTituloAcademico']);
    }
);