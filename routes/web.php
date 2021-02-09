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

Route::post('/project', 'ProductiveController@showProjectList')
    ->name('connectToProductive');

Route::get('/project/{project_id}/taskLists', 'ProductiveController@taskLists')
    ->name('taskLists');

Route::post('/uploadTasks', 'ProductiveController@uploadTasks')
    ->name('uploadTasks');