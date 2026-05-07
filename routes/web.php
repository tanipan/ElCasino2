<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Estáticas
//Route::get('/pruebas', [HomeController::class, 'pruebas'])->name('front.index');
// Route::get('/', [HomeController::class, 'index'])->name('front.index');
Route::post('/autoLogin', [HomeController::class, 'autoLogin'])->name('front.autoLogin');
Route::get('/', [HomeController::class, 'recoger'])->name('front.recoger');
Route::get('/carta', [HomeController::class, 'carta'])->name('front.carta');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('front.contacto');
// Route::post('/contactoEnviar', [HomeController::class, 'contactoEnviar'])->name('front.contactoEnviar');
Route::get('/acceso', [HomeController::class, 'login'])->name('front.login');
Route::get('/recordar', [HomeController::class, 'recordar'])->name('front.recordar');
Route::post('/recordar1', [HomeController::class, 'recordar1'])->name('front.recordar1');
Route::get('/recordar2', [HomeController::class, 'recordar2'])->name('front.recordar2');
Route::post('/recordar3', [HomeController::class, 'recordar3'])->name('front.recordar3');
//Route::get('/privacidad', [HomeController::class, 'privacidad'])->name('front.privacidad');
Route::get('/registro', [HomeController::class, 'registro'])->name('front.registro');
//Route::get('/pedido', [HomeController::class, 'pedido'])->name('front.pedido');
Route::get('/resumen', [HomeController::class, 'resumen'])->name('front.resumen');
Route::match(['get', 'post'], '/resumenFin', [HomeController::class, 'resumenFin'])->name('front.resumenFin');
Route::get('/perfil', [HomeController::class, 'perfil'])->name('front.perfil');
Route::get('/salir', [HomeController::class, 'logout'])->name('front.logout');
// Route::get('/proceso', [HomeController::class, 'proceso'])->name('front.proceso');
// Route::get('/movil', [HomeController::class, 'movil'])->name('front.movil');
// Route::get('/cesta-movil', [HomeController::class, 'cestaMovil'])->name('front.cestaMovil');

// //Peticiones ajax
Route::get('/recuperarModalPlato', [DishController::class, 'recuperarModalPlato'])->name('front.recuperarModalPlato');
Route::get('/recuperarPrecioModalPlato', [DishController::class, 'recuperarPrecioPlato'])->name('front.recuperarPrecioModalPlato');
Route::get('/cargarCesta', [DishController::class, 'cargarCesta'])->name('front.cargarCesta');
Route::get('/insertarEnCesta', [DishController::class, 'insertarEnCesta'])->name('front.insertarEnCesta');
Route::get('/actualizarCesta', [DishController::class, 'actualizarCesta'])->name('front.actualizarCesta');
Route::get('/deBDaCesta', [DishController::class, 'deBDaCesta'])->name('front.deBDaCesta');
Route::get('/cargarResumenCesta', [DishController::class, 'cargarResumenCesta'])->name('front.cargarResumenCesta');
Route::post('/cargarResumenCestaMesa', [DishController::class, 'cargarResumenCestaMesa'])->name('front.cargarResumenCestaMesa');
Route::get('/cargarPedidoRealizado', [DishController::class, 'cargarPedidoRealizado'])->name('front.cargarPedidoRealizado');

Route::get('/setearDescuento', [DishController::class, 'setearDescuento'])->name('front.setearDescuento');

// //Registro de cliente
Route::post('/registrarCliente', [CustomerController::class, 'registrarCliente'])->name('front.registrarCliente');
Route::post('/validarLogin', [CustomerController::class, 'validarLogin'])->name('front.validarLogin');
Route::any('/validarLoginToken', [CustomerController::class, 'validarLoginToken'])->name('front.validarLoginToken');
Route::post('/modificarDatos', [CustomerController::class, 'modificarDatos'])->name('front.modificarDatos');
Route::post('/modificarPassword', [CustomerController::class, 'modificarPassword'])->name('front.modificarPassword');

// //Gestión del pedido
Route::get('/registrarPedido', [OrderController::class, 'registrarPedido'])->name('front.registrarPedido');
Route::get('/pagoOk', [OrderController::class, 'pagoOk'])->name('front.pagoOk');
Route::get('/pagoKo', [OrderController::class, 'pagoKo'])->name('front.pagoKo');
Route::post('/notificacionPago', [OrderController::class, 'notificacionPago'])->name('front.notificacionPago');
Route::get('/notificacionPagoTest555bnm', [OrderController::class, 'notificacionPagoTest'])->name('front.notificacionPagoTest');
// Route::get('/seguimientoPedido/{token}', [OrderController::class, 'seguimientoPedido'])->name('front.seguimientoPedido');

Route::get('/testMail', [OrderController::class, 'testMail'])->name('front.testMail');
Route::get('/testTpv', [OrderController::class, 'testTpv'])->name('front.testTpv');
Route::get('/testMail2', [OrderController::class, 'testMail2'])->name('front.testMail2');
// Route::get('/json', [OrderController::class, 'generateJsonOrder'])->name('front.generateJsonOrder');

// Route::get('/jsonTest', [OrderController::class, 'testGenerateJsonOrder'])->name('front.testGenerateJsonOrder');

Route::get('/reprintTickets', [OrderController::class, 'reprintTickets'])->name('reprintTickets');

Route::get('/alergenos', [StaticController::class, 'alergenos'])->name('alergenos');
Route::get('/privacidad', [StaticController::class, 'privacidad'])->name('privacidad');
Route::get('/legal', [StaticController::class, 'legal'])->name('legal');
Route::get('/cookies', [StaticController::class, 'cookies'])->name('cookies');

//Gestión de mesas
Route::get('/readToQr', [TableController::class, 'readToQr'])->name('readToQr');
Route::get('/tableLogin/{token}', [TableController::class, 'tableLogin'])->name('tableLogin');
Route::get('/tableMenu', [TableController::class, 'tableMenu'])->name('tableMenu');
Route::get('/notifyWaiter', [TableController::class, 'notifyWaiter'])->name('notifyWaiter');
Route::get('/unnotifyWaiter', [TableController::class, 'unnotifyWaiter'])->name('unnotifyWaiter');
Route::get('/unnotifyAccount', [TableController::class, 'unnotifyAccount'])->name('unnotifyAccount');
Route::get('/resumenMesa', [TableController::class, 'resumenMesa'])->name('front.resumen.mesa');
Route::get('/cuentaMesa', [TableController::class, 'cuentaMesa'])->name('front.cuenta.mesa');
Route::get('/notifyAccount', [TableController::class, 'notifyAccount'])->name('notifyAccount');

Route::get('/ultimoTicketMesa', [TableController::class, 'ultimoTicketMesa'])->name('front.ultimoticket.mesa');
Route::post('/cargarResumenCestaUltimoTicketMesa', [DishController::class, 'cargarResumenCestaUltimoTicketMesa'])->name('front.cargarResumenCestaUltimoTicketMesa');
Route::get('/marcamosPagadasLineasUltimoTicket', [TableController::class, 'marcamosPagadasLineasUltimoTicket'])->name('front.marcamosPagadasLineasUltimoTicket');
Route::get('/addPagar', [DishController::class, 'addPagar'])->name('front.addPagar');
Route::get('/subPagar', [DishController::class, 'subPagar'])->name('front.subPagar');
