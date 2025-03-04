<?php

use App\Http\Controllers\cashier\CashierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOfferController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DineTableController;
use App\Http\Controllers\headchef\HeadChefController;
use App\Http\Controllers\host\HostController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;

use App\Http\Controllers\ToppingController;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/host/dashboard', [HostController::class,'dashboard'])->name('host.dashboard');
Route::get('/headchef/dashboard', [HeadChefController::class, 'dashboard'])->name('headchef.dashboard');
Route::get('/cashier/dashboard', [CashierController::class, 'dashboard'])->name('cashier.dashboard');
Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
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
//profile
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}/{role}/update', [ProfileController::class, 'update'])->name('profile.update');

//headchef-order
Route::get('/order/{id}/status/edit', [CustomerOrderController::class, 'edit'])->name('order.edit');
Route::put('/order/{id}/status/update', [CustomerOrderController::class, 'update'])->name('order.update');
Route::get('/order/{id}/view', [CustomerOrderController::class, 'viewMenuItems'])->name('order.view');

//headchef-menuitem
Route::get('/menuitem/{id}/view', [MenuItemController::class, 'view'])->name('menuitem.view');

//cashier
Route::get('/cashier/{id}/additem', [CashierController::class, 'selectQuantity'])->name('cashier.additem');
Route::get('/cashier/order/view', [CashierController::class, 'order'])->name('cashier.order');
Route::get('/cashier/offers/view', [CashierController::class, 'offers'])->name('cashier.offers');
Route::post('/cashier/checkout', [CashierController::class, 'checkout'])->name('cashier.checkout');
Route::post('/cashier/invoice', [CashierController::class, 'invoice'])->name('cashier.invoice');
Route::get('/cashier/order/history', [CashierController::class, 'history'])->name('cashier.order.history');

//manager
Route::get('/manager/menuitems', [ManagerController::class, 'menu'])->name('manager.menuitems');
Route::post('/menuitem/create', [MenuItemController::class, 'create'])->name('menuitem.create');
Route::put('/menuitem/{id}/update', [MenuItemController::class, 'update'])->name('menuitem.update');
Route::delete('/menuitem/{id}/delete', [MenuItemController::class, 'delete'])->name('menuitem.delete');
Route::get('/manager/toppings', [ManagerController::class, 'toppings'])->name('manager.toppings');
Route::get('/manager/offers', [ManagerController::class, 'offers'])->name('manager.offers');
Route::get('/manager/returns', [ManagerController::class, 'returns'])->name('manager.returns');
Route::post('/manager/returns/create', [ManagerController::class, 'add_return'])->name('manager.addreturn');
Route::delete('/manager/returns/{id}/delete', [ManagerController::class, 'delete_return'])->name('manager.deletereturn');
Route::get('/manager/order/history', [ManagerController::class, 'order_history'])->name('manager.order.history');
Route::get('/manager/order/history/{id}/view', [ManagerController::class, 'view_order_history'])->name('manager.order.history.view');
Route::get('/manager/view/feedback', [ManagerController::class, 'feedback'])->name('manager.feedback');

//toppings
Route::post('/topping/create', [ToppingController::class, 'create'])->name('topping.create');
Route::put('/topping/{id}/update', [ToppingController::class, 'update'])->name('topping.update');
Route::delete('/toppings/{id}/delete', [ToppingController::class, 'delete'])->name('topping.delete');

//customer offer
Route::post('offer/create', [CustomerOfferController::class, 'create'])->name('offer.create');
Route::put('/offer/{id}/update', [CustomerOfferController::class, 'update'])->name('offer.update');
Route::delete('/offer/{id}/delete', [CustomerOfferController::class, 'delete'])->name('offer.delete');


//api-routes
Route::get('api/get-customer-name', [CustomerController::class, 'getFullName'])->name('api.customer.name');
Route::get('/api/menuitem/{id}/get', [MenuItemController::class, 'get'])->name('api.menuitem.get');
Route::get('/api/topping/{id}/get', [ToppingController::class, 'get'])->name('api.topping.get');
Route::get('/api/offer/{id}/get', [CustomerOfferController::class, 'get'])->name('api.offer.get');

Route::post('/welcome', function(){
    return view('welcome');
})->name('welcome');