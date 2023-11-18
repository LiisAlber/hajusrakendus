<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('markers', \App\Http\Controllers\MarkerController::class);

Route::name('markers.create')->get('/markers/create', 'MarkerController@create');


