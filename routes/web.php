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

// Routes catalog
Route::get('catalogo', 'CatalogController@index')->name('catalog');
Route::get('producto/{slug}', function () {
    return view('single-product');
});
// Route::get('/home', 'HomeController@index')->name('home');

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

// Routes categories
Route::get('categories', 'CategoryController@index');