<?php

use App\Http\Route;

Route::get('/', 'HomeController@index')->register();

Route::get('/users/fetch',   'UserController@fetch')->middleware('jwt')->register();

Route::post('/users/create', 'UserController@store')->register();
Route::post('/users/auth',   'UserController@login')->register();

Route::put('/users/update',  'UserController@update')->middleware('jwt')->register();

Route::get('/quotes/fetch',          'QuoteController@fetch')->register();
Route::get('/quotes/all',            'QuoteController@index')->middleware('jwt')->register();
Route::get('/quotes/{id}/fetch',     'QuoteController@findOne')->middleware('jwt')->register();

Route::post('/quotes/create',        'QuoteController@store')->middleware('jwt')->register();

Route::put('/quotes/{id}/update',    'QuoteController@update')->middleware('jwt')->register();

Route::delete('/quotes/{id}/delete', 'QuoteController@delete')->middleware('jwt')->register();