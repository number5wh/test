<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'Login\LoginController@login');
Route::get('/login','Login\LoginController@login');
Route::get('/register','Login\LoginController@register');
Route::any('validate/img','Service\ValidateController@create');
Route::any('validate/sms','Service\ValidateController@sendSMS');
Route::get('member/all','MemberController@all');
