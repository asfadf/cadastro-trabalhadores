<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'CadastroController@index');
Route::post('/enviar-cadastro', 'CadastroController@index');
Route::get('/api/form/fields', 'CadastroController@getFormFields');
