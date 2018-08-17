<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/json/confirm-voucher/{code}/{email}/{date?}', ['uses' => 'ApiController@confirm_voucher_json']);
Route::get('/json/vouchers/{email}', ['uses' => 'ApiController@voucher_json']);