<?php
use App\Http\Route;

Route::get('/',                     'HomeController@index');
Route::post('/users/create',        'UserController@store');
Route::post('/users/login',         'UserController@login');
Route::get('/users/fetch',          'UserController@fetch');
Route::get('/users/update',         'UserController@update');
Route::get('/users/{id}/delete',    'UserController@remove');

?>