<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\SalesFController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\StarterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DishTypeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderPhoneController;
use App\Http\Controllers\RestaurantFController;
use App\Http\Controllers\ModificationController;
use App\Http\Controllers\ModificationTypeController;

//////////////////////////////////////////////////////////////////////////////
//El control de acceso de estas rutas esta en el fichero RouteServiceProvider
//////////////////////////////////////////////////////////////////////////////

//User
Route::get('/', [UserController::class, 'index'])->name('admin.user.list');
Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('admin.user.edit');
Route::put('/user/update/{user}', [UserController::class, 'update'])->name('admin.user.update');
Route::delete('/user/delete/{user}', [UserController::class, 'destroy'])->name('admin.user.delete');

//Customer
Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.list');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('admin.customer.create');
Route::get('/customer/{customer}', [CustomerController::class, 'show'])->name('admin.customer.show');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('admin.customer.store');
Route::get('/customer/edit/{customer}', [CustomerController::class, 'edit'])->name('admin.customer.edit');
Route::put('/customer/update/{customer}', [CustomerController::class, 'update'])->name('admin.customer.update');
Route::delete('/customer/delete/{customer}', [CustomerController::class, 'destroy'])->name('admin.customer.delete');

//Address
Route::get('/address/edit/{address}/{customer}', [AddressController::class, 'edit'])->name('admin.address.edit');
Route::put('/address/update/{address}/{customer}', [AddressController::class, 'update'])->name('admin.address.update');
Route::get('/address/setAsPrimary/{address}/{customer}', [AddressController::class, 'setAsPrimary'])->name('admin.address.setAsPrimary');
Route::get('/address/{customer}', [AddressController::class, 'index'])->name('admin.address.list');
Route::get('/address/create/{customer}', [AddressController::class, 'create'])->name('admin.address.create');
Route::get('/address/{address}/{customer}', [AddressController::class, 'show'])->name('admin.address.show');
Route::post('/address/store/{customer}', [AddressController::class, 'store'])->name('admin.address.store');
Route::delete('/address/delete/{address}/{customer}', [AddressController::class, 'destroy'])->name('admin.address.delete');

//DishType
Route::get('/dishType', [DishTypeController::class, 'index'])->name('admin.dishType.list');
Route::get('/dishType/edit/{dishType}', [DishTypeController::class, 'edit'])->name('admin.dishType.edit');
Route::put('/dishType/update/{dishType}', [DishTypeController::class, 'update'])->name('admin.dishType.update');
Route::get('/dishType/create', [DishTypeController::class, 'create'])->name('admin.dishType.create');
Route::get('/dishType/{dishType}', [DishTypeController::class, 'show'])->name('admin.dishType.show');
Route::post('/dishType/store', [DishTypeController::class, 'store'])->name('admin.dishType.store');
Route::delete('/dishType/delete/{dishType}', [DishTypeController::class, 'destroy'])->name('admin.dishType.delete');
Route::get('/dishType/upPosition/{dishType}', [DishTypeController::class, 'upPosition'])->name('admin.dishType.upPosition');
Route::get('/dishType/downPosition/{dishType}', [DishTypeController::class, 'downPosition'])->name('admin.dishType.downPosition');

//Dish
Route::get('dish', [DishController::class, 'index'])->name('admin.dish.list');
Route::get('/dish/create', [DishController::class, 'create'])->name('admin.dish.create');
Route::get('/dish/createModif/{dish}', [DishController::class, 'createModif'])->name('admin.dish.create2');
Route::get('/dish/createExtra/{dish}', [DishController::class, 'createExtra'])->name('admin.dish.create3');
Route::post('/dish/store', [DishController::class, 'store'])->name('admin.dish.store');
Route::get('/dish/edit/{dish}', [DishController::class, 'edit'])->name('admin.dish.edit');
Route::put('/dish/update/{dish}', [DishController::class, 'update'])->name('admin.dish.update');
Route::delete('/dish/delete/{dish}', [DishController::class, 'destroy'])->name('admin.dish.delete');
Route::get('/dish/upPosition/{dish}', [DishController::class, 'upPosition'])->name('admin.dish.upPosition');
Route::get('/dish/downPosition/{dish}', [DishController::class, 'downPosition'])->name('admin.dish.downPosition');

//Order
Route::get('order', [OrderController::class, 'index'])->name('admin.order.list');
Route::get('pendingOrders', [OrderController::class, 'pendingOrders'])->name('admin.order.pending');
Route::get('orderModal', [OrderController::class, 'orderModal'])->name('admin.order.modal');
Route::get('modalTableTotal', [OrderController::class, 'modalTableTotal'])->name('admin.order.modalTableTotal');
Route::get('orderTime', [OrderController::class, 'orderTime'])->name('admin.order.time');
Route::get('roomSituation', [OrderController::class, 'roomSituation'])->name('admin.roomSituation');
Route::get('roomSituationAjax', [OrderController::class, 'roomSituationAjax'])->name('admin.roomSituationAjax');

//ModificationType
Route::get('modification', [ModificationTypeController::class, 'index'])->name('admin.modification.list');
Route::post('/modification/store', [ModificationTypeController::class, 'store'])->name('admin.modification.store');

//Modification
Route::get('/modification/generateModifTable/{dish}', [ModificationController::class, 'generateModificationTable'])->name('admin.modification.table');

//Stock
Route::get('/stock', [StockController::class, 'stock'])->name('admin.stock.list');
Route::get('/stockAdd', [StockController::class, 'add'])->name('admin.stock.add');
Route::get('/stockCheck', [StockController::class, 'check'])->name('admin.stock.check');

//Config
Route::get('/config', [ConfigController::class, 'index'])->name('admin.config.list');
Route::post('/update', [ConfigController::class, 'update'])->name('admin.config.update');

//TimeControl
Route::get('/timeControl', [UserController::class, 'timeControl'])->name('admin.user.timeControl');
Route::post('/timeControlStorage', [UserController::class, 'timeControlStorage'])->name('admin.user.timeControlStorate');
Route::get('/setCookie', [UserController::class, 'setCookie'])->name('admin.user.setCookie');
Route::get('/checkCookie', [UserController::class, 'checkCookie'])->name('admin.user.checkCookie');
Route::get('/informeTime', [UserController::class, 'informeTime'])->name('admin.user.informeTime');

//Inventory
//Route::get('/inventory', [InventoryController::class, 'inventory'])->name('admin.user.inventory');


//Informe
Route::get('/informe', [OrderController::class, 'informe'])->name('admin.order.informe');

//Menu
Route::get('/menu', [MenuController::class, 'index'])->name('admin.menu.index');
Route::post('/menu/upload', [MenuController::class, 'upload'])->name('admin.menu.upload');

//Location
Route::get('/location', [LocationController::class, 'index'])->name('admin.location.list');
Route::get('/location/create', [LocationController::class, 'create'])->name('admin.location.create');
Route::post('/location/store', [LocationController::class, 'store'])->name('admin.location.store');
Route::get('/location/edit/{location}', [LocationController::class, 'edit'])->name('admin.location.edit');
Route::post('/location/update/{location}', [LocationController::class, 'update'])->name('admin.location.update');
Route::delete('/location/delete/{location}', [LocationController::class, 'destroy'])->name('admin.location.delete');

//Tables
Route::get('/table', [TableController::class, 'index'])->name('admin.table.list');
Route::get('/table/create', [TableController::class, 'create'])->name('admin.table.create');
Route::post('/table/store', [TableController::class, 'store'])->name('admin.table.store');
Route::get('/table/edit/{table}', [TableController::class, 'edit'])->name('admin.table.edit');
Route::post('/table/update/{table}', [TableController::class, 'update'])->name('admin.table.update');
Route::delete('/table/delete/{table}', [TableController::class, 'destroy'])->name('admin.table.delete');
Route::post('/table/aceptOrder', [TableController::class, 'aceptOrder'])->name('admin.table.aceptOrder');
Route::post('/table/cancelOrder', [TableController::class, 'cancelOrder'])->name('admin.table.cancelOrder');

Route::post('/table/servedLine', [TableController::class, 'servedLine'])->name('admin.table.servedLine');
Route::post('/table/unservedLine', [TableController::class, 'unservedLine'])->name('admin.table.unservedLine');

//QRcodes
Route::get('/qrcode/{table}', [QrcodeController::class, 'show'])->name('admin.qrcode.index');

//Burgers
Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');
Route::get('/preparedB', [BurgerController::class, 'prepared'])->name('orderlineburgers.prepared');
Route::get('/unpreparedB', [BurgerController::class, 'unprepared'])->name('orderlineburgers.unprepared');
Route::get('/orderHideB', [BurgerController::class, 'orderHide'])->name('orderlineburgers.orderHide');
Route::get('/toFire', [BurgerController::class, 'toFire'])->name('orderlineburgers.toFire');
Route::get('/reloadB', [BurgerController::class, 'reload'])->name('burgers.reload');

//Starters
Route::get('/starters', [StarterController::class, 'index'])->name('admin.starters.index');
Route::get('/prepared', [StarterController::class, 'prepared'])->name('admin.orderline.prepared');
Route::get('/unprepared', [StarterController::class, 'unprepared'])->name('admin.orderline.unprepared');
Route::get('/orderHide', [StarterController::class, 'orderHide'])->name('admin.orderline.orderHide');
Route::get('/reload', [StarterController::class, 'reload'])->name('admin.starters.reload');

//Tasks
Route::get('/tasks', [TaskController::class, 'index'])->name('admin.task.index');
Route::get('/marcar', [TaskController::class, 'marcar'])->name('admin.task.marcar');
Route::get('/desmarcar', [TaskController::class, 'desmarcar'])->name('admin.task.desmarcar');


//RestaurantF
Route::get('/restaurantF', [RestaurantFController::class, 'index'])->name('admin.restaurantF.list');
Route::get('/restaurantF/create', [RestaurantFController::class, 'create'])->name('admin.restaurantF.create');
Route::post('/restaurantF/store', [RestaurantFController::class, 'store'])->name('admin.restaurantF.store');
Route::get('/restaurantF/edit/{restaurant}', [RestaurantFController::class, 'edit'])->name('admin.restaurantF.edit');
Route::put('/restaurantF/update/{restaurant}', [RestaurantFController::class, 'update'])->name('admin.restaurantF.update');
Route::delete('/restaurantF/delete/{restaurant}', [RestaurantFController::class, 'destroy'])->name('admin.restaurantF.delete');

//Sales
Route::get('/sales', [SalesFController::class, 'sales'])->name('admin.sales');
Route::get('/salesInforme', [SalesFController::class, 'informe'])->name('admin.sales.informe');

//Buscar cliente por telefono
Route::get('/orderPhone/search', [OrderPhoneController::class, 'search'])->name('admin.customer.search');
