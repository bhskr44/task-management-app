<?php

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


Route::post('/add-task', [App\Http\Controllers\TaskController::class, 'addTask']);
Route::get('/home', [App\Http\Controllers\TaskController::class, 'home']);
Route::get('/', [App\Http\Controllers\TaskController::class, 'home']);
Route::get('/get-tasks/{taskId}', [App\Http\Controllers\TaskController::class, 'getTask']);
Route::post('/edit-task', [App\Http\Controllers\TaskController::class, 'editTask']);
Route::post('/delete-task', [App\Http\Controllers\TaskController::class, 'deletetask']);


