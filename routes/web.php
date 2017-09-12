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



	Route::resource('uploadfile', 'UploadFileController');

	Route::get('file', 'PrintJobController@showUploadForm')->name('upload.file');

	Route::post('file', 'PrintJobController@storeFile');


	Route::resource('/patron', 'PatronController');



	Route::resource('/admin/payment', 'PaymentController');

	Route::post('/update-payment-status', 'PaymentController@updatePaymentStatus');


	Route::get('/test', function(){

        auth()->login(\App\Models\Patron::findOrFail(3));
		auth()->user()->notify(new App\Notifications\PrintJobRejectionNotification('2'));

	});

	Route::get('download/{filename}', function ($filename) {
	    $printJob = \App\Models\PrintJob::whereFilename($filename)->first();
    	return response()->download(storage_path('app') . '/' . $filename, $printJob->original_filename);
	})->where('filename', '(.*)');

    Route::post('/admin/printer/sort', 'PrinterController@sort')->name('printer.sort');
	Route::resource('/admin/printer', 'PrinterController');

	Route::put('/admin/{id}','AdminController@update')->name('admin.update');
 

});

Route::group(['middleware' => ['cas.auth', 'patron.auth']], function() {

    Route::get('/', 'PublicController@index')->name('home');
    Route::get('/printers', 'PublicController@printers')->name('printers');
    Route::get('/policy', 'PublicController@policy')->name('policy');

    // Workflow for choosing best-priced printer
    Route::get('/options', 'PatronController@options')->name('options');
    Route::get('/choose-printer', 'PatronController@choosePrinter')->name('choose-printer');
    Route::get('/uploads', 'PatronController@upload')->name('uploads');
    Route::get('/submit', 'PatronController@submit')->name('submit');
    Route::get('/history', 'PatronController@history')->name('history');

    Route::get('/register', 'RegistrationController@edit')->name('register');
    Route::put('/register', 'RegistrationController@update')->name('register');
});




