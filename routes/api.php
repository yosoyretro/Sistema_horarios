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
use App\Http\Controllers\PlanificacionAcademica;
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
//middleware('auth.sanctum')
Route::prefix('istg')->group(
    function () {
        //INSTITUTO
        Route::get("show_data_instituto/", [InstitutoController::class, 'showInstituto']);
        Route::put("update_instituto/", [InstitutoController::class, 'updateInstituto']);
        Route::post("create_instituto/", [InstitutoController::class, 'storeInstituto']);
        Route::delete("delete_instituto/", [InstitutoController::class, 'deleteInstituto']);
        //ASIGNATURA
        Route::get("show_data_asignatura/", [AsignaturaController::class, 'showAsignatura']);
        Route::put("update_asignatura/{id}", [AsignaturaController::class, 'updateAsignatura']);
        Route::post("create_asignatura/", [AsignaturaController::class, 'storeAsignatura']);
        Route::delete("delete_asignatura/{id}", [AsignaturaController::class, 'deleteAsignatura']);
        //CARRERA
        Route::get("show_carrera/", [CarreraController::class, 'showCarrera']);
        Route::put("update_carrera/{id}", [CarreraController::class, 'updateCarrera']);
        Route::post("create_carrera/", [CarreraController::class, 'storeCarrera']);
        Route::delete("delete_carrera/{id}", [CarreraController::class, 'deleteCarrera']);
        //NIVEL
        Route::get("show_nivel/", [NivelController::class, 'showNivel']);
        Route::put("update_nivel/{id}", [NivelController::class, 'updateNivel']);
        Route::post("create_nivel/", [NivelController::class, 'storeNivelCarrera']);
        Route::delete("delete_nivel/{id}", [NivelController::class, 'deleteNivel']);
        //PARALELO
        Route::get("showParalelo/", [ParaleloController::class, 'showParalelo']);
        Route::put("update_paralelo/{id}", [ParaleloController::class, 'updateParalelo']);
        Route::post("create_paralelo/", [ParaleloController::class, 'storeParalelo']);
        Route::delete("delete_paralelo/{id}", [ParaleloController::class, 'deleteParalelo']);
        //USUARIO
        Route::post("create_usuario/", [UsuarioController::class, 'storeUsuarios']);
        // Route::post("edit_usuario/", [UsuarioController::class, 'editUser']);
        Route::delete("delete_usuario/{id}", [UsuarioController::class, 'deleteUsuario']);
        Route::get("show_usuario/", [UsuarioController::class, 'showUsuarios']);
        // //Roles 
        Route::get("show_roles/", [RolController::class, 'getRoles']);
        Route::post("create_rol/", [RolController::class, 'storeRol']);
        Route::delete("delete_rol/", [RolController::class, 'deleteRol']);
        // //TITUTLOS ACADEMICO
        // Route::post("create_titulo_academico/", [TituloAcademicoController::class, 'createTituloAcademico']);
        // Route::post("update_titulo_academico/", [TituloAcademicoController::class, 'updateTituloAcademico']);
        // Route::post("delete_titulo_academico/", [TituloAcademicoController::class, 'deleteTituloAcademico']);
        // Route::get("show_data_titulo_academico/", [TituloAcademicoController::class, 'showTituloAcademico']);
        Route::group(
            [
                "prefix" => "horario/",
            ],
            function () {
                Route::post("create_horario/", [DistribucionHorario::class, 'storeHorario']);
            }
        );
        Route::group(
            [
                "prefix" => "Planificaciones/"
            ],
            function (){
                Route::post("createPlanificacionAcademico",[PlanificacionAcademica::class,'store']);
                Route::get("getPlanificacionAcademicas",[PlanificacionAcademica::class,'getPlanificacionAcademica']);
            }
        );
    }
);
