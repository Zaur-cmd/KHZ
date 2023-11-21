<?php

use App\Http\Controllers\Gateway1Controller;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\Gateway2Controller;
use Illuminate\Support\Facades\Route;

Route::post('/gateway1/callback', [Gateway1Controller::class, 'handleCallback']);
Route::post('/gateway2/callback', [Gateway2Controller::class, 'handleCallback']);
