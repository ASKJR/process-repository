<?php

use Illuminate\Support\Facades\Redirect;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categories', 'ProcessCategoryController');

Route::resource('category/{category}/processes', 'ProcessController');

Route::resource('process/{process}/reviews', 'ProcessReviewController');
Route::get('process/{process}/reviews/{review}/download', 'ProcessReviewController@downloadReviewFile')->name('reviews.download');
