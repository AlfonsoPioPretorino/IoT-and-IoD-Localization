<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PacketsController;


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

Route::get('/', [ViewController::class, 'viewHome'])->name('view.home');
Route::post('/session/add', [SessionController::class, 'addSession'])->name('session.add');
Route::get('/session/map/{id}', [SessionController::class, 'viewMap'])->name('session.map');

Route::get('/collectdata', [ViewController::class, 'collectdata'])->name('collectdata');


//API Calls
Route::get('/token', function () {
    return csrf_token(); 
});
