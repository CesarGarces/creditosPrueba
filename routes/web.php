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
Route::post('/creditos/', 'CrediController@show');

Route::get('/creditos/{Documento}', 'CrediController@find')->where('Documento', '[0-9]+');
Route::get('/abonos/{Documento}', 'CrediController@abono')->where('Documento', '[0-9]+');
Route::post('/valor/{Documento}', 'CrediController@valor')->where('Documento', '[0-9]+');