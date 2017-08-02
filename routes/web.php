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


//Route::group(['middleware' => ['web']], function() {
	
	Route::get('/admin', 'AdminController@index');

	Route::resource('/admin/department', 'DepartmentController');

	Route::resource('/admin/filament', 'FilamentController');

	Route::resource('/admin/user', 'UserController');
	Route::resource('/admin/color', 'ColorController');

	Route::resource('/admin/status', 'StatusController');




//});

