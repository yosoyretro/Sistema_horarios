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
Route::get('usuario',[SgcController::class,'usuario'])->name('usuario');
Route::get('lista',[SgcController::class,'lista'])->name('lista');

Route::post('eliminarRegistro',[SgcController::class,'eliminarRegistro']);
Route::post('login-controlador',[SgcController::class,'login_controlador'])->name('login_controlador');
