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

Route::get('/', 'ProductiveController@index');

Route::post('/project', 'ProductiveController@connect')
    ->name('connectToProductive');

Route::get('/taskList', 'ProductiveController@taskList')
    ->name('taskList');

Route::get('/uploadCSV', 'ProductiveController@uploadCSV')
    ->name('uploadCSV');