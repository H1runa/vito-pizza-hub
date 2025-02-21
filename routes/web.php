<?php

use App\Http\Controllers\DineTableController;
use App\Http\Controllers\host\HostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/host/dashboard', [HostController::class,'dashboard'])->name('host.dashboard');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//host-table
Route::get('/dinetable/create', [DineTableController::class, 'create'])->name('dinetable.create');
Route::post('/dinetable/store', [DineTableController::class, 'store'])->name('dinetable.store');
Route::get('/dinetable/{id}/edit', [DineTableController::class, 'edit'])->name('dinetable.edit');
Route::put('/dinetable/{id}', [DineTableController::class, 'update'])->name('dinetable.update');
Route::delete('/dinetable/{id}', [DineTableController::class, 'delete'])->name('dinetable.delete');

Route::post('/welcome', function(){
    return view('welcome');
})->name('welcome');