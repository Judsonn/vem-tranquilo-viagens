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
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

Route::resource('user', 'UserController', ['except' => ['show']]);
Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::prefix('onibus')->group(function () {
    Route::resource('urbano', 'OnibusUrbanoController');
    Route::resource('intermunicipal', 'OnibusIntermunicipalController');
});

Route::resource('passageiro', 'PassageiroController');

Route::prefix('trajeto')->group(function () {
    Route::resource('urbano', 'TrajetoUrbanoController');
    Route::resource('intermunicipal', 'TrajetoIntermunicipalController');
});

Route::prefix('tarifa')->group(function () {
    Route::resource('urbano', 'TarifaLocalController');
    Route::resource('intermunicipal', 'TarifaIntermunicipalController');
});

Route::resource('funcionario', 'AlocarFuncionarioController');

Route::resource('pagamento', 'FormaDePagamentoController');