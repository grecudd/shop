<?php

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

Route::resource('/items', 'App\Http\Controllers\ItemsController')
    ->middleware('auth', ['except' => ['items.index', 'items.shows']]);

Route::resource('/items', 'App\Http\Controllers\ItemsController', ['only', ['items.index', 'items.show']]);

Route::get('/', function () {
    return redirect()->route('items.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', 'App\Http\Controllers\ShopController@profile')->name('profile');

    Route::post('/buy', 'App\Http\Controllers\ShopController@buy')->name('shop.buy');

    Route::get('logOut', 'App\Http\Controllers\ShopController@logOut')->name('shop.logOut');
});

Route::post('/add-to-cart/{item}', 'App\Http\Controllers\ShopController@addToCart')->name('shop.addToCart');

Route::get('/cart', 'App\Http\Controllers\ShopController@showCart')->name('shop.showCart');

Route::post('/remove-from-cart/{item}', 'App\Http\Controllers\ShopController@removeFromCart')
    ->name('shop.removeFromCart');

Route::post('/remove-all', 'App\Http\Controllers\ShopController@removeAll')->name('shop.removeAll');

Route::get('/search', 'App\Http\Controllers\ShopController@search')->name('shop.search');

Route::get('/sort-price', 'App\Http\Controllers\ShopController@sortPrice')->name('shop.sortPrice');
