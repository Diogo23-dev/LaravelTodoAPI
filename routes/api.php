<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('todos', TodoController::class);
Route::patch('todos/{todo}/complete', [TodoController::class, 'complete']);

// Route des APIs pour l'authentification
Route::post('register', [App\Http\Controllers\Auth\Register::class, '__invoke'])->name('register');
Route::post('login', [App\Http\Controllers\Auth\Login::class, '__invoke'])->name('login');
Route::post('logout', [App\Http\Controllers\Auth\Logout::class, '__invoke'])->name('logout')->middleware('auth:sanctum');
