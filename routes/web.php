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

	Route::get('/admin', 'AdminController@index')->name('admin');

	Route::resource('/admin/department', 'DepartmentController');

	Route::resource('/admin/filament', 'FilamentController');

	Route::resource('/admin/user', 'UserController');
	Route::resource('/admin/color', 'ColorController');

	Route::resource('/admin/status', 'StatusController');

	// Workflow for choosing best-priced printer
	Route::get('/options', 'UploadFileController@options')->name('options');
	Route::get('/printers', 'UploadFileController@printers')->name('printers');
	Route::get('/uploads', 'UploadFileController@upload')->name('uploads');

	Route::resource('/uploadfile', 'UploadFileController');

	Route::get('file', 'PrintJobController@showUploadForm')->name('upload.file');

	Route::post('file', 'PrintJobController@storeFile');


	Route::resource('/patron', 'PatronController');



	Route::resource('/admin/payment', 'PaymentController');

	Route::post('/update-payment-status', 'PaymentController@updatePaymentStatus');


	Route::get('/test', function(){

        auth()->login(\App\Models\Patron::findOrFail(3));
		auth()->user()->notify(new App\Notifications\SendDifferentFileNotification('2'));

	});

	Route::get('download/{filename}', function ($filename) {
    	return response()->download(storage_path('app') . '/' . $filename);
	})->where('filename', '(.*)');
	
	Route::resource('/admin/printer', 'PrinterController');

	Route::put('/admin/{id}','AdminController@update')->name('admin.update');
 


//});

