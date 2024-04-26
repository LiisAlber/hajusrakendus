<?php

use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
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

    if ($limit = request('limit')) {
        return Cache::remember('my-request'.$limit, now()->addHour(), fn () => Tools::paginate($limit));
    }
    return Tools::all();
});

/*if ($limit = $request->input('limit')) {
    $validatedLimit = (int) $limit;  // Cast to integer to avoid potential SQL injection or errors
    if ($validatedLimit <= 0) {
        return response()->json(['error' => 'Limit must be a positive integer'], 400);
    }
    return Cache::remember('my-request' . $validatedLimit, now()->addHour(), fn () => Tools::paginate($validatedLimit));
}
*/