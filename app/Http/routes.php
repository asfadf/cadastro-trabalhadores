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

Route::get('/', 'VolunteerController@index');

Route::get('/api/volunteer/fields', 'VolunteerController@getVolunteerFields');
Route::post('/api/volunteer', 'VolunteerController@addVolunteer');

Route::get('/generate-pdf', 'VolunteerController@generatePDF');

