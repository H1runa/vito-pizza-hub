<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DineTableController;
use App\Http\Controllers\headchef\HeadChefController;
use App\Http\Controllers\host\HostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/host/dashboard', [HostController::class,'dashboard'])->name('host.dashboard');
Route::get('/headchef/dashboard', [HeadChefController::class, 'dashboard'])->name('headchef.dashboard');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
//host-table
Route::get('/dinetable/create', [DineTableController::class, 'create'])->name('dinetable.create');
Route::post('/dinetable/store', [DineTableController::class, 'store'])->name('dinetable.store');
Route::get('/dinetable/{id}/edit', [DineTableController::class, 'edit'])->name('dinetable.edit');
Route::put('/dinetable/{id}', [DineTableController::class, 'update'])->name('dinetable.update');
Route::delete('/dinetable/{id}', [DineTableController::class, 'delete'])->name('dinetable.delete');
//host-reservation
Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation/store', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');
Route::delete('/reservation/{id}', [ReservationController::class, 'delete'])->name('reservation.delete');
//host-profile
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');

//headchef-order-status
Route::get('/order/{id}/status/edit', [CustomerOrderController::class, 'edit'])->name('order.edit');
Route::put('/order/{id}/status/update', [CustomerOrderController::class, 'update'])->name('order.update');

//api-routes
Route::get('api/get-customer-name', [CustomerController::class, 'getFullName'])->name('api.customer.name');

Route::post('/welcome', function(){
    return view('welcome');
})->name('welcome');