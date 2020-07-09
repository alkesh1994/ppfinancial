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
  Route::get('/', 'HomeController@index')->name('home');

  //Client routes group
  Route::prefix('clients')->namespace('Client')->as('clients.')->group(function() {

    Route::get('/list', 'ClientController@list')->name('list');

    Route::view('/create-client', 'dashboard.client.create')->name('create_client');

    Route::post('/store','ClientController@store')->name('store');

    Route::get('/edit-client/{id}', function (App\Models\Client\Client $id) {
    	return view('dashboard.client.edit')->with('client', $id);
    })->name('edit_client');

    Route::get('/delete-client', 'ClientController@store')->name('delete_client');

  });


});
