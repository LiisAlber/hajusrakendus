<?php

use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tools', function(Request $request){
    dd(request());
    if ($limit = request('limit')) {
        return Cache::remember('my-request'.$limit, now()->addHour(), fn () => Tools::paginate($limit));
    }
    return Tools::all();
});
