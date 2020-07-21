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

    Route::get('/edit-client/{slug}', 'ClientController@edit')->name('edit_client');

    Route::post('/update/{id}','ClientController@update')->name('update');

    Route::get('/delete-client/{id}', 'ClientController@destroy')->name('delete_client');

  });

  //Accounts routes group
  Route::namespace('Client')->as('clients.accounts.')->group(function() {

    Route::get('clients/{slug}/accounts/list', 'AccountController@list')->name('list');

    Route::post('clients/accounts/store','AccountController@store')->name('store');

    Route::get('clients/{clientSlug}/accounts/delete-account/{accountId}', 'AccountController@destroy')->name('delete_account');

    Route::post('clients/accounts/withdraw','AccountController@withdraw')->name('withdraw');

  });

  //Passbook routes group
  Route::namespace('Client')->as('clients.accounts.passbook.')->group(function() {

    Route::get('clients/{clientSlug}/accounts/{accountSlug}/passbook/show', 'PassbookController@show')->name('show');

    Route::get('clients/{clientSlug}/accounts/{accountSlug}/passbook/export-passbook-pdf','PassbookController@export_passbook_pdf')->name('export_passbook_pdf');

  });


});
