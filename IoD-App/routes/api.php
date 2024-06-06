<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacketsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API CALL
Route::post('/save-packet', [PacketsController::class, 'savePacket'])->name('packet.save');
Route::post('/triangulation', [PacketsController::class, 'triangulate'])->name('packet.triangulate');
Route::post('/recive-single-packet', [PacketsController::class, 'recive_single_packet'])->name('packet.recive_single_packet');
Route::post('/write-single-packet', [PacketsController::class, 'write_single_packet'])->name('packet.write_single_packet');

