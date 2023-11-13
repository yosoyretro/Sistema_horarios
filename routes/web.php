<?php

use App\Http\Controllers\SgcController;
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

Route::get('login',[SgcController::class,'login'])->name('login');
Route::get('inicio',[SgcController::class,'inicio'])->name('inicio');
Route::get('crear',[SgcController::class,'crear'])->name('crear');
Route::get('cursos',[SgcController::class,'cursos'])->name('cursos');
Route::get('carrera',[SgcController::class,'carrera'])->name('carrera');
Route::get('docentes',[SgcController::class,'docentes'])->name('docentes');
Route::get('asignaciones',[SgcController::class,'asignaciones'])->name('asignaciones');

Route::post('login-controlador',[SgcController::class,'login_controlador'])->name('login_controlador');
