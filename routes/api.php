<?php

use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\InstitutoController;
use App\Http\Controllers\TituloAcademicoController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\DiasController;
use App\Http\Controllers\DistribucionHorario;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Middleware\AutenticacionSistema;
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



Route::post('autenticar_sistema_istg',[AutenticacionController::class,'autenticacion']);
// middleware('auth.sanctum')->prefix('istg')->group
Route::prefix('istg')->group(
    function () {
        //INSTITUTO
        Route::post("create_instituto/", [InstitutoController::class, 'createInstituto']);
        Route::post("update_instituto/", [InstitutoController::class, 'UpdateInstituto']);
        Route::post("delete_instituto/", [InstitutoController::class, 'deleteInstituto']);
        Route::get("show_data_instituto/", [InstitutoController::class, 'showData']);
        //ASIGNATURA
        Route::post("create_asignatura/", [AsignaturaController::class, 'createAsignatura']);
        Route::post("update_asignatura/", [AsignaturaController::class, 'updateAsignatura']);
        Route::post("delete_asignatura/", [AsignaturaController::class, 'deleteAsignatura']);
        Route::get("show_data_asignatura/", [AsignaturaController::class, 'showAsignatura']);
        //CARRERA
        Route::post("create_carrera/", [CarreraController::class, 'createCarrera']);
        Route::post("update_carrera/", [CarreraController::class, 'updateCarrera']);
        Route::post("delete_carrera/", [CarreraController::class, 'deleteCarrera']);
        Route::get("show_carrera/", [CarreraController::class, 'showCarrera']);
        //NIVEL
        Route::post("create_nivel/", [NivelController::class, 'createNivel']);
        Route::post("update_nivel/", [NivelController::class, 'updateNivel']);
        Route::post("delete_nivel/", [NivelController::class, 'deleteNivel']);
        Route::get("show_nivel/", [NivelController::class, 'showNivel']);
        //PARALELO
        Route::post("create_paralelo/", [ParaleloController::class, 'createParalelo']);
        Route::post("update_paralelo/", [ParaleloController::class, 'updateParalelo']);
        Route::post("delete_paralelo/", [ParaleloController::class, 'deleteParalelo']);
        Route::get("show_data_paralelo/", [ParaleloController::class, 'showParalelo']);
        //DIAS
        Route::post("create_dias/", [DiasController::class, 'createDias']);
        Route::post("update_dias/", [DiasController::class, 'updateDias']);
        Route::post("delete_dias/", [DiasController::class, 'deleteDias']);
        Route::get("show_data_dias/", [DiasController::class, 'showDias']);
        //USUARIO
        Route::post("create_usuario/", [UsuarioController::class, 'createUsuario']);
        Route::post("edit_usuario/", [UsuarioController::class, 'editUser']);
        Route::post("delete_usuario/", [UsuarioController::class, 'deleteUsuario']);
        Route::get("show_usuario/", [UsuarioController::class, 'showUsuario']);
        //Roles
        Route::get("show_roles/", [RolController::class, 'showRol']);
        //TITUTLOS ACADEMICO
        Route::post("create_titulo_academico/", [TituloAcademicoController::class, 'createTituloAcademico']);
        Route::post("update_titulo_academico/", [TituloAcademicoController::class, 'updateTituloAcademico']);
        Route::post("delete_titulo_academico/", [TituloAcademicoController::class, 'deleteTituloAcademico']);
        Route::get("show_data_titulo_academico/", [TituloAcademicoController::class, 'showTituloAcademico']);
        Route::group(
            [
                "prefix" => "v1/horario/",
            ],
            function () {
                Route::post("create_horario/", [DistribucionHorario::class, 'storeHorario']);
            }
        );
    }
);
