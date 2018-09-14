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
Route::group(['middleware' => ['mail']], function() {
    Auth::routes();
});

Route::group(['middleware' => ['auth', 'mail']], function() {


	Route::get('/admin', 'AdminController@index')->name('admin');

	Route::resource('/admin/department', 'DepartmentController');

    Route::post('/admin/filament/sort', 'FilamentController@sort')->name('filament.sort');
    Route::post('/admin/filament/{id}/toggle-printer', 'FilamentController@togglePrinter')->name('filament.toggle-printer');
    Route::get('/admin/filament/{filamentid}/printer/{printerid}/colors', 'FilamentController@showColorManager')->name('filament.color-manager');
    Route::post('/admin/filament/{filamentid}/printer/{printerid}/colors', 'FilamentController@updateColorManager')->name('filament.color-manager');
    Route::get('/admin/filament/{filamentid}/printer/{printerid}/pricing', 'FilamentController@showPricingManager')->name('filament.pricing-manager');
    Route::post('/admin/filament/{filamentid}/printer/{printerid}/pricing', 'FilamentController@updatePricingManager')->name('filament.pricing-manager');
	Route::resource('/admin/filament', 'FilamentController');

    Route::get('/admin/patron', 'PatronAdminController@index')->name('admin.patron.index');
    Route::delete('/admin/patron/{id}', 'PatronAdminController@destroy')->name('admin.patron.destroy');

    Route::get('/admin/settings', 'SettingsController@index')->name('settings.index');
    Route::post('/admin/settings', 'SettingsController@update')->name('settings.update');

	Route::resource('/admin/user', 'UserController');
    Route::post('/admin/color/sort', 'ColorController@sort')->name('color.sort');
	Route::resource('/admin/color', 'ColorController');
    Route::post('/admin/notification/sort', 'NotificationController@sort')->name('notification.sort');
	Route::resource('/admin/notification', 'NotificationController');
    Route::post('/admin/printer/sort', 'PrinterController@sort')->name('printer.sort');
    Route::resource('/admin/printer', 'PrinterController');

	Route::post('/admin/status/sort', 'StatusController@sort')->name('status.sort');
	Route::resource('/admin/status', 'StatusController');
    Route::resource('/admin/payment', 'PaymentController');

    Route::get('/admin/charts', 'ChartsController@index')->name('charts');

    Route::get('/admin/email/{id}', 'AdminController@createEmail')->name('admin.create-email');
    Route::post('/admin/email/{id}', 'AdminController@sendEmail')->name('admin.send-email');


    Route::get('/admin/coupons', 'CouponController@index')->name('coupons.index');
    Route::post('/admin/coupons', 'CouponController@store')->name('coupons.store');
    Route::delete('/admin/coupons/{id}', 'CouponController@destroy')->name('coupons.destroy');



    Route::get('/admin/{id}', 'AdminController@edit')->name('admin.edit');







	Route::resource('uploadfile', 'UploadFileController');
    Route::post('/reprint/{id}', 'AdminController@reprint')->name('admin.reprint');

	Route::resource('/patron', 'PatronController');

	Route::post('/update-payment-status', 'PaymentController@updatePaymentStatus');

	Route::get('download/{filename}', 'PatronController@download')->where('filename', '(.*)')->name('download');

	Route::put('/admin/{id}','AdminController@update')->name('admin.update');




});

Route::group(['middleware' => ['cas.auth', 'patron.auth', 'mail']], function() {

    Route::get('/', 'PublicController@index')->name('home');
    Route::get('/printers', 'PublicController@printers')->name('printers');
    Route::get('/policy', 'PublicController@policy')->name('policy');
    Route::get('/contact', 'PublicController@contact')->name('contact');
    Route::post('/send-email', 'PublicController@sendEmail')->name('send-email');

    Route::get('/quote', 'CostController@quote')->name('quote');

    // Workflow for choosing best-priced printer
    Route::get('/options', 'PatronController@options')->name('options');
    Route::get('/choose-printer', 'PatronController@choosePrinter')->name('choose-printer');
    Route::get('/upload', 'PatronController@upload')->name('upload');
    Route::post('/submit', 'PatronController@submit')->name('submit');
    Route::get('/history', 'PatronController@history')->name('history');
    Route::get('/history/{id}', 'PatronController@show')->name('show');
    Route::delete('/history/{id}', 'PatronController@destroy')->name('job.delete');

    Route::get('/register', 'RegistrationController@edit')->name('register');
    Route::put('/register', 'RegistrationController@update')->name('register');
});




