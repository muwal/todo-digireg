<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

Route::get('/todo', [TodoController::class, 'index']);
Route::post('/todo', [TodoController::class, 'store']);
Route::get('/todo/{id?}', [TodoController::class, 'show']);
Route::put('/todo/update/{id?}', [TodoController::class, 'update']);
Route::delete('/todo/{id?}', [TodoController::class, 'destroy']);
