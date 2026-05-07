<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesFController;
use App\Http\Controllers\RestaurantFController;
use App\Http\Controllers\ModificationController;
use App\Http\Controllers\ModificationTypeController;

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

//ModificationsType
Route::get('/modificationsType', [ModificationTypeController::class, 'indexApi'])->name('modificationType.list');
Route::post('/modificationsType/store', [ModificationTypeController::class, 'storeApi'])->name('modificationType.store');

Route::post('/modifications/store', [ModificationController::class, 'storeApi'])->name('modification.store');
Route::post('/modifications/update', [ModificationController::class, 'updateApi'])->name('modification.update');
Route::post('/modifications/delete', [ModificationController::class, 'deleteApi'])->name('modification.delete');
Route::get('/modification', [ModificationController::class, 'indexApi'])->name('modification.index');


//Orders
Route::post('orderAccept', [OrderController::class, 'orderAccept'])->name('admin.order.accept');
Route::post('orderCancel', [OrderController::class, 'orderCancel'])->name('admin.order.cancel');
Route::post('orderChangeStatus', [OrderController::class, 'orderChangeStatus'])->name('admin.order.changeStatus');
Route::post('orderChangesStatus', [OrderController::class, 'orderChangesStatus'])->name('admin.order.changesStatus');
Route::post('orderChangeStatusPay', [OrderController::class, 'orderChangeStatusPay'])->name('admin.order.changeStatusPay');
Route::post('orderDelete', [OrderController::class, 'orderDelete'])->name('admin.order.delete');

//Tickets
Route::post('/tickets', [OrderController::class, 'tickets'])->name('ticketsv1');
Route::post('/ticketsPrinted', [OrderController::class, 'ticketsPrinted'])->name('ticketsPrinted');
Route::post('/v2/tickets', [OrderController::class, 'ticketsV2'])->name('tickets');

//Test
Route::post('/syncCaUrban', [TestController::class, 'syncCaUrban'])->name('syncCaUrban');
//Route::get('/getInvoiceSAP', [TestController::class, 'getInvoiceSAP'])->name('syncCaUrban');


//Burger
Route::post('/getBurger', [RestaurantFController::class, 'getBurger'])->name('getBurger');
Route::post('/sellingBurgers', [SalesFController::class, 'sellingBurgers'])->name('sellingBurgers');
Route::post('/getSales', [SalesFController::class, 'getSales'])->name('getSales');
Route::post('/deleteSale', [SalesFController::class, 'deleteSale'])->name('deleteSale');

//Elementos
Route::get('/ocultarElemento', [DishController::class, 'ocultarElemento'])->name('ocultarElemento');