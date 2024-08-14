<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\SubscriptionController;

// Home page route
Route::get('/', [WeatherController::class, 'index'])->name('weather.index');

// Weather search route
Route::post('/search', [WeatherController::class, 'search'])->name('weather.search');
Route::get('/search', [WeatherController::class, 'index'])->name('get.search');

// Weather history route
Route::get('/weather/history', [WeatherController::class, 'history'])->name('weather.history');

// Weather location route
Route::post('/weather/location', [WeatherController::class, 'getWeatherByLocation'])->name('weather.location');

// Store temporary weather route
Route::post('/weather/temporary', [WeatherController::class, 'storeTemporaryWeather'])->name('weather.temporary');

// Subscription routes
Route::post('subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
Route::get('unsubscribe/{token}', [SubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
Route::get('verify/{email}/{token}', [SubscriptionController::class, 'verifySubscription'])->name('verify.subscription');
