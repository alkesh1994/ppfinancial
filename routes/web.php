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
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('/', function () {
    return view('login');
});

Auth::routes();

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {

  //Dashboard home
  Route::get('/', 'HomeController@index');

  //Client routes group
  Route::prefix('clients')->namespace('Client')->as('clients.')->group(function() {

    Route::get('/', 'ClientController@list')->name('list');

    Route::view('/add-new-client', 'dashboard.client.create')->name('add_new_client');

    Route::post('/store','ClientController@store')->name('store');

  });


});
