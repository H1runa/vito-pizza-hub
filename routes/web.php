<?php

use App\Http\Controllers\host\HostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/host/dashboard', [HostController::class,'dashboard'])->name('host.dashboard');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/welcome', function(){
    return view('welcome');
})->name('welcome');