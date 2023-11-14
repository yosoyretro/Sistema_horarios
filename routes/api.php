<?php

use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\InstitutoController;
use App\Http\Controllers\PeriodoElectivoController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(
    [
        "prefix" => "v1/horario/",
    ],function(){
        //TITUTLOS ACADEMICO
        Route::post("create_titulo_academico/",[TituloAcademicoController::class,'createTituloAcademico']);
        Route::post("update_titulo_academico/",[TituloAcademicoController::class,'updateTituloAcademico']);
        Route::post("delete_titulo_academico/",[TituloAcademicoController::class,'deleteTituloAcademico']);
        Route::get("show_data_titulo_academico/",[TituloAcademicoController::class,'showTituloAcademico']);
        //INSTITUTO
        Route::post("create_instituto/",[InstitutoController::class,'createInstituto']);
        Route::post("update_instituto/",[InstitutoController::class,'UpdateInstituto']);
        Route::post("delete_instituto/",[InstitutoController::class,'deleteInstituto']);
        Route::get("show_data_insituto/",[InstitutoController::class,'showData']);
        //ASIGNATURA
        Route::post("create_asignatura/",[AsignaturaController::class,'createAsignatura']);
        Route::post("update_asignatura/",[AsignaturaController::class,'updateAsignatura']);        
        Route::post("delete_asignatura/",[AsignaturaController::class,'deleteAsignatura']);
        Route::get("show_data_asignatura/",[AsignaturaController::class,'showAsignatura']);
        //CARRERA
        Route::post("create_carrera/",[CarreraController::class,'createCarrera']);
        Route::post("update_carrera/",[CarreraController::class,'updateCarrera']);
        Route::post("delete_carrera/",[CarreraController::class,'deleteCarrera']);
        Route::get("show_carrera/",[CarreraController::class,'showCarrera']);

        Route::post("create_periodo/",[PeriodoElectivoController::class,'createPeriodo']);
        Route::post("update_periodo/",[PeriodoElectivoController::class,'updatePeriodo']);
        Route::post("delete_periodo/",[PeriodoElectivoController::class,'deletePeriodo']);
        Route::get("show_periodo/",[PeriodoElectivoController::class,'showPeriodo']);
        

    }   
);