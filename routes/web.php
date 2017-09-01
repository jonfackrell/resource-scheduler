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

    Route::post('/admin/filament/sort', 'FilamentController@sort')->name('filament.sort');
    Route::post('/admin/filament/{id}/toggle-printer', 'FilamentController@togglePrinter')->name('filament.toggle-printer');
    Route::get('/admin/filament/{filamentid}/printer/{printerid}/colors', 'FilamentController@showColorManager')->name('filament.color-manager');
    Route::post('/admin/filament/{filamentid}/printer/{printerid}/colors', 'FilamentController@updateColorManager')->name('filament.color-manager');
    Route::get('/admin/filament/{filamentid}/printer/{printerid}/pricing', 'FilamentController@showPricingManager')->name('filament.pricing-manager');
    Route::post('/admin/filament/{filamentid}/printer/{printerid}/pricing', 'FilamentController@updatePricingManager')->name('filament.pricing-manager');
	Route::resource('/admin/filament', 'FilamentController');

	Route::resource('/admin/user', 'UserController');
	Route::resource('/admin/color', 'ColorController');

	Route::post('/admin/status/sort', 'StatusController@sort')->name('status.sort');
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
	    $printJob = \App\Models\PrintJob::whereFilename($filename)->first();
    	return response()->download(storage_path('app') . '/' . $filename, $printJob->original_filename);
	})->where('filename', '(.*)');

    Route::post('/admin/printer/sort', 'PrinterController@sort')->name('printer.sort');
	Route::resource('/admin/printer', 'PrinterController');

	Route::put('/admin/{id}','AdminController@update')->name('admin.update');

	Route::get('/admin/charts', 'ChartsController@index');
 


//});

