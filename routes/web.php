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

Auth::routes();

Route::group(['middleware' => ['auth']], function() {


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
    Route::resource('/admin/payment', 'PaymentController');

    Route::get('/admin/email/{id}', 'AdminController@createEmail')->name('admin.create-email');
    Route::post('/admin/email/{id}', 'AdminController@sendEmail')->name('admin.send-email');
    Route::get('/admin/{id}', 'AdminController@edit')->name('admin.edit');


	Route::resource('uploadfile', 'UploadFileController');
	Route::get('file', 'PrintJobController@showUploadForm')->name('upload.file');

	Route::resource('/patron', 'PatronController');

	Route::post('/update-payment-status', 'PaymentController@updatePaymentStatus');


	Route::get('/test', function(){



	});

	Route::get('download/{filename}', function ($filename) {
	    $printJob = \App\Models\PrintJob::whereFilename($filename)->first();
    	return response()->download(storage_path('app') . '/' . $filename, $printJob->original_filename);
	})->where('filename', '(.*)')->name('download');

    Route::post('/admin/printer/sort', 'PrinterController@sort')->name('printer.sort');
	Route::resource('/admin/printer', 'PrinterController');

	Route::put('/admin/{id}','AdminController@update')->name('admin.update');

	Route::get('/admin/charts', 'ChartsController@index')->name('charts');;
 

});

Route::group(['middleware' => ['cas.auth', 'patron.auth']], function() {

    Route::get('/', 'PublicController@index')->name('home');
    Route::get('/printers', 'PublicController@printers')->name('printers');
    Route::get('/policy', 'PublicController@policy')->name('policy');

    // Workflow for choosing best-priced printer
    Route::get('/options', 'PatronController@options')->name('options');
    Route::get('/choose-printer', 'PatronController@choosePrinter')->name('choose-printer');
    Route::get('/upload', 'PatronController@upload')->name('upload');
    Route::post('/submit', 'PatronController@submit')->name('submit');
    Route::get('/history', 'PatronController@history')->name('history');

    Route::get('/register', 'RegistrationController@edit')->name('register');
    Route::put('/register', 'RegistrationController@update')->name('register');
});




