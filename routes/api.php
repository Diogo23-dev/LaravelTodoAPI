<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Login;




// Route des APIs pour l'authentification
Route::post('register', [App\Http\Controllers\Auth\Register::class, '__invoke'])->name('register');
Route::post('login', [App\Http\Controllers\Auth\Login::class, '__invoke'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [App\Http\Controllers\Auth\Logout::class, '__invoke'])->name('logout');
    
    Route::apiResource('todos', TodoController::class);
    
    Route::patch('todos/{todo}/complete', [TodoController::class, 'complete']);

});

