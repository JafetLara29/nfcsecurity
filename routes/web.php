<?php

use App\Http\Controllers\SOSController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

/**
 * |---------------------
 *  |Rutas para usuarios-
 * |---------------------
 */
Route::resource('/users', UserController::class);


/**
 * |---------------------------------
 *  |Rutas para lo relacionado a SOS-
 * |---------------------------------
 */
Route::post('/sos', [SOSController::class, 'makeSOSCall'])->name('sos');
Route::get('/sos/report', [SOSController::class, 'index'])->name('sos.report');
Route::post('/sos/check', [SOSController::class, 'checkSOS'])->name('sos.check');
Route::post('/sos/checked', [SOSController::class, 'checked'])->name('sos.checked');


Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
