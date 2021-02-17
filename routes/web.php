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

Route::group(['middleware' => ['auth']],function(){
	Route::get('/home', 'HomeController@index')->name('home');

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

	// REPORT
	Route::get('/report/pasien','ReportController@indexPasien')->name('report.pasien.index');
	Route::get('/report/pasien/print','ReportController@printPasien')->name('report.pasien.print');
	Route::get('/report/pembayaran','ReportController@indexPembayaran')->name('report.pembayaran.index');
	Route::get('/report/pembayaran/print','ReportController@printPembayaran')->name('report.pembayaran.print');

	// USER
	Route::get('/security/user','UserController@index')->name('user.index');
	Route::get('/security/user/register','UserController@register')->name('user.register');
	Route::get('/security/user/data','UserController@getData')->name('user.data');
	Route::post('/security/user/adduser','UserController@addUser')->name('user.add')->middleware('can:isSuperAdmin');
	Route::post('/security/user/addrole','UserController@addRole')->name('user.add.role');
	Route::post('/security/user/simpan','UserController@simpan')->name('user.simpan')->middleware('can:isSuperAdmin');
	Route::post('/security/user/hapus','UserController@hapus')->name('user.hapus')->middleware('can:isSuperAdmin');

	// ROLE
	Route::get('/security/role','RoleController@index')->name('role.index');
	Route::get('/security/role/data','RoleController@getData')->name('role.data');
	Route::get('/security/role/user/{id}','RoleController@getRoleUser')->name('role.user')->middleware('can:isSuperAdmin');
	Route::post('/security/role/simpan','RoleController@simpan')->name('role.simpan')->middleware('can:isSuperAdmin');
	Route::post('/security/role/user/hapus','RoleController@hapusRoleUser')->name('role.user.hapus')->middleware('can:isSuperAdmin');
});