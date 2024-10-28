<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index']);
Route::post('/create', [TodoController::class, 'create']);
Route::post('/update', [TodoController::class, 'update']);
Route::get('/update-status/{id}/{status}', [TodoController::class, 'update_status']);
Route::get('/delete/{id}', [TodoController::class, 'delete']);
