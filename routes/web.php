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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Routes categories
Route::resource('categories', 'CategoryController');
// Routes attributes
Route::resource('attributes', 'AttributeController');

// Routes user
Route::group(['middleware' => ['auth']], function () {
    Route::get('users/{id}', 'UserController@show');
    // Routes admin
    Route::get('admin', function () {
        return view('admin');
    });
    // Routes products
    Route::resource('product', 'ProductController');
});

// Routes catalog
Route::get('catalogo', 'CatalogController@index')->name('catalog');
Route::get('product-index', 'ProductController@index');
Route::get('producto/{slug}', function() {
    return view('single-product');
});
Route::get('producto/single/{slug}', 'CatalogController@show');

// Routes cart localstorage
Route::get('add/{slug}', 'CatalogController@addItem');
Route::get('carrito', function() {
    return view('cart');
});
Route::get('pagos', function () {
    return view('checkout');
});
