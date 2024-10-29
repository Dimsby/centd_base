<?php

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

/*
Route::get('/', function () {
    return view('welcome');
}); */


Route::get('/', 'HomeController@index');

Route::get('/search/{id}', 'HomeController@search')->name('search');;
Route::get('/file/{id}', 'HomeController@file')->name('file');;

Route::post('/testpost', 'HomeController@testpost');

Auth::routes(['register' => false]);


Route::get('/dashboard', 'DashboardController@index');

Route::resource('person', 'PersonController');

Route::middleware('admin')->group(function () {
    Route::resource('user', 'UserController')->only([
        'index', 'store', 'update', 'destroy'
    ]);
});

Route::post('person/updPub/{id}', 'PersonController@updPublished');

Route::get('sources/{filename}', 'PersonController@displayImage');
