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
    Auth::routes();

	Route::get('/admin', 'AdminController@index');

	Route::resource('/admin/department', 'DepartmentController');

	Route::resource('/admin/filament', 'FilamentController');

	Route::resource('/admin/user', 'UserController');
	Route::resource('/admin/color', 'ColorController');

	Route::resource('/admin/status', 'StatusController');

	Route::resource('/uploadfile', 'UploadFileController');

	Route::get('file', 'PrintJobController@showUploadForm')->name('upload.file');

	Route::post('file', 'PrintJobController@storeFile');


	Route::resource('/patron', 'PatronController');



	Route::resource('/payment', 'PaymentController');

	Route::get('/test', function(){

		auth()->user()->notify(new App\Notifications\SendDifferentFileNotification('3'));

	});


//});

