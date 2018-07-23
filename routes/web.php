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

Route::group(['prefix'=>'admin'], function(){
	Route::group(['prefix'=>'theloai'], function(){
		Route::get('danhsach', 'TheLoaiController@getDanhSach');

		Route::get('sua/{id}', 'TheLoaiController@getSua');
		Route::post('sua/{id}', 'TheLoaiController@postSua');

		Route::get('them', 'TheLoaiController@getThem');
		Route::post('them', 'TheLoaiController@postThem');
	});

	Route::group(['prefix'=>'loaitin'], function(){
		Route::get('danhsach', 'LoaiTinController@getDanhSach');

		Route::get('sua', 'LoaiTinController@getSua');

		Route::get('them', 'LoaiTinController@getThem');
	});

	Route::group(['prefix'=>'tintuc'], function(){
		Route::get('danhsach', 'TinTucController@getDanhSach');

		Route::get('sua', 'TinTucController@getSua');

		Route::get('them', 'TinTucController@getThem');
	});

	Route::group(['prefix'=>'comment'], function(){
		Route::get('danhsach', 'CommentController@getDanhSach');

		Route::get('sua', 'CommentController@getSua');

		Route::get('them', 'CommentController@getThem');
	});

	Route::group(['prefix'=>'user'], function(){
		Route::get('danhsach', 'UserController@getDanhSach');

		Route::get('sua', 'UserController@getSua');

		Route::get('them', 'UserController@getThem');
	});

	Route::group(['prefix'=>'slider'], function(){
		Route::get('danhsach', 'SliderController@getDanhSach');

		Route::get('sua', 'SliderController@getSua');

		Route::get('them', 'SliderController@getThem');
	});
});