<?php

use App\Http\Controllers\TodosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/",[TodosController::class,"index"]);

Route::get("/tareas",[TodosController::class,"listar"]);

Route::post("/tareas", [TodosController::class,"guardar"]);

Route::get("/tareas/{id}",[TodosController::class,"obtener"]);

Route::patch("/tareas/{id}", [TodosController::class,"actualizar"]);

Route::delete("/tareas/{id}", [TodosController::class,"eliminar"]);