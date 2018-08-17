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

Route::get('/', function () {
	return view('welcome');
});


Route::resource('recipient', 'RecipientController');
Route::resource('special-offer', 'SpecialOfferController');
Route::resource('voucher', 'VoucherController');
Route::get('/late-vouchers/{special_offer}', ['as' => 'vouchers.late-vouchers', 'uses' => 'VoucherController@generate_later_vouchers']);
Route::get('/vouchers/{email}', ['as' => 'vouchers.email', 'uses' => 'VoucherController@get_vouchers']);
Route::get('/send-voucher/{code}/{email}', ['as' => 'vouchers.send-voucher', 'uses' => 'VoucherController@send_voucher']);
Route::get('/voucher/{code}/{email}', ['as' => 'vouchers.confirm', 'uses' => 'VoucherController@confirm_voucher']);
Route::post('/voucher/{code}/{email}', ['uses' => 'VoucherController@confirm_voucher_post']);