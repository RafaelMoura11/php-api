<?php
use App\Http\Route;

Route::get('/', 'HomeController@notIndex');
Route::get('/about', 'HomeController@index');

?>