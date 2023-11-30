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

Route::view('login',[SgcController::class,'login'])->name('login');
Route::view('inicio',[SgcController::class,'inicio'])->name('inicio');
Route::view('cursos',[SgcController::class,'cursos'])->name('cursos');
Route::view('carrera',[SgcController::class,'carrera'])->name('carrera');
Route::get('usuarios',[SgcController::class,'usuarios'])->name('usuarios');
Route::view('asignaciones',[SgcController::class,'asignaciones'])->name('asignaciones');
Route::view('horarios',[SgcController::class,'horarios'])->name('horarios');
Route::view('asignatura',[SgcController::class,'asignatura'])->name('asignatura');
Route::post('login-controlador',[SgcController::class,'login_controlador'])->name('login_controlador');
