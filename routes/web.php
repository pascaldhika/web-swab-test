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

// FRONTEND
Route::get('/','FrontEndController@index')->name('frontend');

// LOGOUT
Route::get('/logout','Auth\LoginController@logout')->name('logout');

// REGISTRASI NOT LOGIN
Route::get('/transaction/registrasi/form','RegistrasiController@form')->name('registrasi.form');
Route::post('/transaction/registrasi/simpan','RegistrasiController@simpan')->name('registrasi.simpan');
Route::get('/transaction/registrasi/print/book','RegistrasiController@printBook')->name('registrasi.print.book');
Route::get('/transaction/registrasi/ceknoidentitas','RegistrasiController@cekNoIdentitas')->name('registrasi.ceknoidentitas');

// RESET PASSWORD
Route::get('/password-request','Auth\ResetPasswordController@request')->name('password.request');
// Route::get('/password-reset','Auth\ResetPasswordController@reset')->name('password.reset');

Route::group(['middleware' => ['auth']],function(){
	Route::get('/home', 'HomeController@index')->name('home');
	// Lil bit Special :)~
    Route::get('getData','HomeController@getData')->name('home.data');
    Route::post('setoutlet','HomeController@setOutlet')->name('home.setoutlet');
    Route::post('cekoutlet', 'HomeController@cekSubcabang')->name('home.cekoutlet');
    Route::get('switchc', 'HomeController@switchc')->name('home.switchc');

	// REGISTRASI
	Route::get('/transaction/registrasi','RegistrasiController@index')->name('registrasi.index');
	Route::get('/transaction/registrasi/data','RegistrasiController@getData')->name('registrasi.data');
	Route::get('/transaction/registrasi/detail','RegistrasiController@formDetail')->name('registrasi.detail');
	Route::get('/transaction/registrasi/edit','RegistrasiController@formEdit')->name('registrasi.edit');
	Route::post('/transaction/registrasi/detail/data','RegistrasiController@getDetail')->name('registrasi.detail.data');
	Route::post('/transaction/registrasi/simpanstatus','RegistrasiController@simpanStatus')->name('registrasi.simpanstatus');
	Route::post('/transaction/registrasi/simpanpayment','RegistrasiController@simpanPayment')->name('registrasi.simpanpayment');
	Route::get('/transaction/registrasi/print/excel','RegistrasiController@printExcel')->name('registrasi.print.excel');
	Route::get('/transaction/registrasi/print/pdf','RegistrasiController@printPdf')->name('registrasi.print.pdf');
	Route::post('/transaction/registrasi/simpanedit','RegistrasiController@simpanEdit')->name('registrasi.simpanedit');
	Route::get('/transaction/registrasi/preview','RegistrasiController@preview')->name('registrasi.preview');
	Route::get('/transaction/registrasi/email','RegistrasiController@email')->name('registrasi.email');

	// REPORT
	Route::get('/report/pasien','ReportController@indexPasien')->name('report.pasien.index');
	Route::get('/report/pasien/print','ReportController@printPasien')->name('report.pasien.print');
	Route::get('/report/pembayaran','ReportController@indexPembayaran')->name('report.pembayaran.index');
	Route::get('/report/pembayaran/print','ReportController@printPembayaran')->name('report.pembayaran.print');

	// USER
	Route::get('/security/user','UserController@index')->name('user.index')->middleware('can:isSuperAdmin');
	Route::get('/security/user/register','UserController@register')->name('user.register')->middleware('can:isSuperAdmin');
	Route::get('/security/user/data','UserController@getData')->name('user.data')->middleware('can:isSuperAdmin');
	Route::post('/security/user/adduser','UserController@addUser')->name('user.add')->middleware('can:isSuperAdmin');
	Route::post('/security/user/addrole','UserController@addRole')->name('user.add.role')->middleware('can:isSuperAdmin');
	Route::post('/security/user/simpan','UserController@simpan')->name('user.simpan')->middleware('can:isSuperAdmin');
	Route::post('/security/user/hapus','UserController@hapus')->name('user.hapus')->middleware('can:isSuperAdmin');
	Route::get('/security/user/password','UserController@changePassword')->name('password.change');
	Route::post('/security/user/password/simpan','UserController@simpanPassword')->name('password.simpan');

	// ROLE
	Route::get('/security/role','RoleController@index')->name('role.index')->middleware('can:isSuperAdmin');
	Route::get('/security/role/data','RoleController@getData')->name('role.data')->middleware('can:isSuperAdmin');
	Route::get('/security/role/user/{id}','RoleController@getRoleUser')->name('role.user')->middleware('can:isSuperAdmin');
	Route::post('/security/role/simpan','RoleController@simpan')->name('role.simpan')->middleware('can:isSuperAdmin');
	Route::post('/security/role/user/hapus','RoleController@hapusRoleUser')->name('role.user.hapus')->middleware('can:isSuperAdmin');

	// MASTER
	Route::get('/master/outlet','OutletController@index')->name('outlet.index')->middleware('can:isSuperAdmin');
	Route::get('/master/outlet/data','OutletController@getData')->name('outlet.data')->middleware('can:isSuperAdmin');
	Route::get('/master/outlet/user/{id}','OutletController@getOutletUser')->name('outlet.user')->middleware('can:isSuperAdmin');
	Route::post('/master/outlet/simpan','OutletController@simpan')->name('outlet.simpan')->middleware('can:isSuperAdmin');
	Route::post('/master/outlet/user/hapus','OutletController@hapusOutletUser')->name('outlet.user.hapus')->middleware('can:isSuperAdmin');
	Route::post('/master/outlet/adduser','OutletController@addUser')->name('outlet.add.user')->middleware('can:isSuperAdmin');

	Route::get('/master/mitra','MitraController@index')->name('mitra.index')->middleware('can:isSuperAdmin');
	Route::get('/master/mitra/data','MitraController@getData')->name('mitra.data')->middleware('can:isSuperAdmin');
	Route::post('/master/mitra/simpan','MitraController@simpan')->name('mitra.simpan')->middleware('can:isSuperAdmin');

	Route::get('/master/payment','PaymentController@index')->name('payment.index')->middleware('can:isSuperAdmin');
	Route::get('/master/payment/data','PaymentController@getData')->name('payment.data')->middleware('can:isSuperAdmin');
	Route::post('/master/payment/simpan','PaymentController@simpan')->name('payment.simpan')->middleware('can:isSuperAdmin');

	Route::get('/master/dokter','DokterController@index')->name('dokter.index')->middleware('can:isSuperAdmin');
	Route::get('/master/dokter/data','DokterController@getData')->name('dokter.data')->middleware('can:isSuperAdmin');
	Route::post('/master/dokter/simpan','DokterController@simpan')->name('dokter.simpan')->middleware('can:isSuperAdmin');

	Route::get('/master/jenisrapid','JenisRapidController@index')->name('jenisrapid.index')->middleware('can:isSuperAdmin');
	Route::get('/master/jenisrapid/data','JenisRapidController@getData')->name('jenisrapid.data')->middleware('can:isSuperAdmin');
	Route::post('/master/jenisrapid/simpan','JenisRapidController@simpan')->name('jenisrapid.simpan')->middleware('can:isSuperAdmin');

	Route::get('/master/harga','HargaController@index')->name('harga.index')->middleware('can:isSuperAdmin');
	Route::get('/master/harga/data','HargaController@getData')->name('harga.data')->middleware('can:isSuperAdmin');
	Route::post('/master/harga/simpan','HargaController@simpan')->name('harga.simpan')->middleware('can:isSuperAdmin');

});