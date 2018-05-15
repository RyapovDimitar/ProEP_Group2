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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['checkHeader'])->group(function () {
    Route::get('/view_all', 'CurrenciesController@see_all');
    Route::get('/view/{currencyname}', 'CurrenciesController@see_concrete');

    Route::get('/make_report/{username}', 'TransactionsController@make_report');

    Route::post('/register_user', 'UsersController@register');

    Route::post('/currency/add', 'CurrenciesController@add');
    Route::post('/currency/update', 'CurrenciesController@changeValue');

    Route::post('/make_transaction', 'TransactionsController@make_transaction');

});
//Route::post('/register_user', array('uses' => 'UsersController@register','middleware' => ['checkHeader']));



