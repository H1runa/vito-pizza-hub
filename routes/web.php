<?php

use App\Http\Controllers\cashier\CashierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOfferController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DineTableController;
use App\Http\Controllers\EPFController;
use App\Http\Controllers\headchef\HeadChefController;
use App\Http\Controllers\host\HostController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ETFController;
use App\Http\Controllers\SalesController;

use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ServiceChargeAllowanceController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffLeaveController;
use App\Http\Controllers\StaffOvertimeAllowanceController;
use App\Http\Controllers\SystemUserController;
use App\Http\Controllers\ToppingController;
use App\Models\MenuItem;
use App\Models\StaffAttendance;
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
Route::get('/manager/staff/view', [ManagerController::class, 'staff'])->name('manager.staff');
Route::get('/manager/sysusers', [ManagerController::class, 'sysusers'])->name('manager.sysusers');
Route::get('manager/salary', [ManagerController::class, 'salary'])->name('manager.salary');
Route::get('manager/epf/view', [ManagerController::class, 'epf'])->name('manager.epf');
Route::get('manager/etf/view', [ManagerController::class, 'etf'])->name('manager.etf');
Route::get('/manager/leaves', [ManagerController::class, 'leaves'])->name('manager.leaves');
Route::get('/manager/attendance', [ManagerController::class, 'attendance'])->name('manager.attendance');
Route::get('/manager/serv/view', [ManagerController::class, 'serv'])->name('manager.serv');
Route::get('/manager/overtime', [ManagerController::class, 'overtime'])->name('manager.overtime');

//toppings
Route::post('/topping/create', [ToppingController::class, 'create'])->name('topping.create');
Route::put('/topping/{id}/update', [ToppingController::class, 'update'])->name('topping.update');
Route::delete('/toppings/{id}/delete', [ToppingController::class, 'delete'])->name('topping.delete');

//customer offer
Route::post('offer/create', [CustomerOfferController::class, 'create'])->name('offer.create');
Route::put('/offer/{id}/update', [CustomerOfferController::class, 'update'])->name('offer.update');
Route::delete('/offer/{id}/delete', [CustomerOfferController::class, 'delete'])->name('offer.delete');

//staff
Route::post('/staff/create', [StaffController::class, 'store'])->name('staff.create');
Route::put('/staff/{id}/update', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{id}/delete', [StaffController::class, 'delete'])->name('staff.delete');

//system user
Route::post('systemuser/create', [SystemUserController::class, 'store'])->name('systemuser.create');
Route::put('systemuser/{id}/update', [SystemUserController::class, 'update'])->name('systemuser.update');
Route::delete('systemuser/{id}/delete', [SystemUserController::class, 'delete'])->name('systemuser.delete');

//salary
Route::post('/salary/create', [SalaryController::class, 'store'])->name('salary.store');
Route::put('salary/{id}/update', [SalaryController::class, 'update'])->name('salary.update');
Route::delete('salary/{id}/delete', [SalaryController::class, 'delete'])->name('salary.delete');

//epf
Route::post('/epf/create', [EPFController::class, 'store'])->name('epf.store');
Route::put('/epf/{id}/update', [EPFController::class, 'update'])->name('epf.update');
Route::delete('/epf/{id}/delete', [EPFController::class, 'delete'])->name('epf.delete');

//etf
Route::post('/etf/create', [ETFController::class, 'store'])->name('etf.store');
Route::put('/etf/{id}/update', [ETFController::class, 'update'])->name('etf.update');
Route::delete('/etf/{id}/delete', [ETFController::class, 'delete'])->name('etf.delete');

//staff leave
Route::post('/leave/create', [StaffLeaveController::class, 'store'])->name('leave.store');
Route::put('/leave/{id}/update', [StaffLeaveController::class, 'update'])->name('leave.update');
Route::delete('/leave/{id}/delete', [StaffLeaveController::class, 'delete'])->name('leave.delete');

//staff attendance
Route::post('/attendance/create', [StaffAttendanceController::class, 'store'])->name('attendance.store');
Route::delete('/attendance/{id}/delete', [StaffAttendanceController::class, 'delete'])->name('attendance.delete');

//serv charge
Route::post('/serv/create', [ServiceChargeAllowanceController::class, 'store'])->name('serv.store');
ROute::delete('/serv/{id}/delete', [ServiceChargeAllowanceController::class, 'delete'])->name('serv.delete');

//staff overtime
Route::post('/overtime/create', [StaffOvertimeAllowanceController::class, 'store'])->name('overtime.store');
ROute::delete('/overtime/{id}/delete', [StaffOvertimeAllowanceController::class, 'delete'])->name('overtime.delete');

//reports
Route::get('manager/reports/sales-week', [SalesController::class, 'salesByDay'])->name('report.sales.week');
Route::get('manager/reports/sales-month', [SalesController::class, 'salesByMonth'])->name('report.sales.month');
Route::get('manager/reports/item-week', [SalesController::class, 'salesByMenuItem'])->name('report.item.week');
Route::get('manager/reports/item-month', [SalesController::class, 'salesByMenuItemMonth'])->name('report.item.month');
Route::get('manager/reports/topping-week', [SalesController::class, 'salesByToppingWeek'])->name('report.topping.week');
Route::get('manager/reports/topping-month', [SalesController::class, 'salesByToppingMonth'])->name('report.topping.month');



//api-routes
Route::get('api/get-customer-name', [CustomerController::class, 'getFullName'])->name('api.customer.name');
Route::get('/api/menuitem/{id}/get', [MenuItemController::class, 'get'])->name('api.menuitem.get');
Route::get('/api/topping/{id}/get', [ToppingController::class, 'get'])->name('api.topping.get');
Route::get('/api/offer/{id}/get', [CustomerOfferController::class, 'get'])->name('api.offer.get');
Route::get('/api/staff/{id}/get', [StaffController::class, 'get'])->name('api.staff.get');
Route::get('api/systemuser/{id}/get', [SystemUserController::class, 'get'])->name('api.systemuser.get');
Route::get('/api/salary/{id}/get', [SalaryController::class, 'get'])->name('api.salary.get');
Route::get('/api/epf/{id}/get', [EPFController::class, 'get'])->name('api.epf.get');
Route::get('/api/etf/{id}/get', [ETFController::class, 'get'])->name('api.etf.get');
Route::get('/api/leave/{id}/get', [StaffLeaveController::class, 'get'])->name('api.leave.get');

Route::post('/welcome', function(){
    return view('welcome');
})->name('welcome');