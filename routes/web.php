<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

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
// Route::get('/weather', [WeatherController::class, 'getWeather'])->name('weather');
Route::get('/weather', [WeatherController::class, 'getWeather'])->name('weather.get');


Route::get('/markers', [MarkerController::class, 'index'])->name('markers.index');
Route::get('/markers/create', [MarkerController::class, 'create'])->name('markers.create');
Route::post('/markers', [MarkerController::class, 'store'])->name('markers.store');
Route::get('/markers/{id}/edit', [MarkerController::class, 'edit'])->name('markers.edit');
Route::put('/markers/{id}', [MarkerController::class, 'update'])->name('markers.update');
Route::delete('/markers/{id}', [MarkerController::class, 'destroy'])->name('markers.destroy');


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/blog', BlogController::class)->middleware('auth');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

// Display all products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Display the shopping cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Add an item to the cart
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

// Remove an item from the cart
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

Route::get('/payment', function () {
    return view('products.payment');
})->name('payment');

Route::get('/confirmation', function () {
    return view('products.confirmation');
})->name('confirmation');

// Display a list of all tools
Route::get('/tools', [ToolsController::class, 'index'])->name('tools.index');

// Display the form for creating a new tool
Route::get('/tools/create', [ToolsController::class, 'create'])->name('tools.create');

// Store a newly created tool
Route::post('/tools', [ToolsController::class, 'store'])->name('tools.store');

// Display the form for editing the specified tool
Route::get('/tools/{tool}/edit', [ToolsController::class, 'edit'])->name('tools.edit');

// Update the specified tool
Route::put('/tools/{tool}', [ToolsController::class, 'update'])->name('tools.update');

// Delete the specified tool
Route::delete('/tools/{tool}', [ToolsController::class, 'destroy'])->name('tools.destroy');

Route::get('show-api', function() {
    $name = request('name');
    $cacheKey = 'api_response_' . $name;
    $cacheTime = 60; // Cache time in minutes

    return Cache::remember($cacheKey, $cacheTime, function () use ($name) {
        $requestUrl = match($name) {
            'Karel' => 'https://hajusrakendus.ta22maarma.itmajakas.ee/api/records',
            'Mari-Liis' => 'https://ralf.ta22sink.itmajakas.ee/api/makeup',
            'Ralf' => 'https://hajus.ta19heinsoo.itmajakas.ee/api/movies',
            'Jan' => 'https://hajusrakendus.ta22korva.itmajakas.ee/api/shopapis',
            default => 'https://hajusrakendus.ta22alber.itmajakas.ee/tools'
        };

        $response = Http::get($requestUrl)->json();

        if (!is_array($response)) {
            Log::warning('Unexpected response format from API: ' . $requestUrl);
            // Return an empty array or some other meaningful default
            return ['error' => 'Unexpected response format'];
        }

        $limit = request('limit', 10); // Default to 10
        return array_slice($response, 0, $limit);
    });
});



require __DIR__.'/auth.php';

// show-api?name=Ralf&limit=2

/*Route::get('show-api', function() {
    $requestUrl = match(request('name')) {
        'Ralf' => 'https://hajus.ta19heinsoo.itmajakas.ee/api/movies',
        default => 'https://hajusrakendus.ta22alber.itmajakas.ee/tools'
    };

    return Http::get($requestUrl, [
        'limit' => request('limit')
    ])->body();
});*/