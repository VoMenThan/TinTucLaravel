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

Route::get('/trangchu', 'PagesController@trangchu');
Route::get('/lienhe', 'PagesController@lienhe');
Route::get('/gioithieu', 'PagesController@gioithieu');
Route::get('/loaitin/{id}/{TenKhongDau}.html', 'PagesController@loaitin');
Route::get('/tintuc/{id}/{TenKhongDau}.html', 'PagesController@tintuc');


Route::get('dangnhap', 'PagesController@getDangnhap');
Route::post('dangnhap', 'PagesController@postDangnhap');

Route::get('dangxuat', 'PagesController@getDangxuat');

Route::get('dangky', 'PagesController@getDangky');
Route::post('dangky', 'PagesController@postDangky');

Route::get('nguoidung', 'PagesController@getNguoidung');
Route::post('nguoidung', 'PagesController@postNguoidung');

Route::post('timkiem', 'PagesController@timkiem');



Route::post('comment/{id}', 'CommentController@postComment');



Route::group(['prefix' => 'admin'], function () {
	
	Route::get('dangnhap', 'UserController@getDangnhapAdmin');
	Route::post('dangnhap', 'UserController@postDangnhapAdmin');

	Route::get('dangxuat', 'UserController@getDangxuat');

});

Route::group(['prefix'=>'admin', 'middleware'=>'adminLogin'], function(){
	Route::group(['prefix'=>'theloai'], function(){
		Route::get('danhsach', 'TheLoaiController@getDanhSach');

		Route::get('them', 'TheLoaiController@getThem');
		Route::post('them', 'TheLoaiController@postThem');

		Route::get('sua/{id}', 'TheLoaiController@getSua');
		Route::post('sua/{id}', 'TheLoaiController@postSua');

		Route::get('xoa/{id}', 'TheLoaiController@getXoa');
	});

	Route::group(['prefix'=>'loaitin'], function(){
		Route::get('danhsach', 'LoaiTinController@getDanhSach');
		
		Route::get('them', 'LoaiTinController@getThem');
		Route::post('them', 'LoaiTinController@postThem');

		Route::get('sua/{id}', 'LoaiTinController@getSua');
		Route::post('sua/{id}', 'LoaiTinController@postSua');


		Route::get('xoa/{id}', 'LoaiTinController@getXoa');
	});

	Route::group(['prefix'=>'tintuc'], function(){
		Route::get('danhsach', 'TinTucController@getDanhSach');
		
		Route::get('them', 'TinTucController@getThem');
		Route::post('them', 'TinTucController@postThem');

		Route::get('sua/{id}', 'TinTucController@getSua');
		Route::post('sua/{id}', 'TinTucController@postSua');


		Route::get('xoa/{id}', 'TinTucController@getXoa');
	});

	Route::group(['prefix'=>'comment'], function(){

		Route::get('xoa/{id}/{idTinTuc}', 'CommentController@getXoa');

	});



	Route::group(['prefix'=>'slider'], function(){
		Route::get('danhsach', 'SliderController@getDanhSach');
		
		Route::get('them', 'SliderController@getThem');
		Route::post('them', 'SliderController@postThem');

		Route::get('sua/{id}', 'SliderController@getSua');
		Route::post('sua/{id}', 'SliderController@postSua');


		Route::get('xoa/{id}', 'SliderController@getXoa');
	});

	Route::group(['prefix'=>'user'], function(){
		Route::get('danhsach', 'UserController@getDanhSach');
		
		Route::get('them', 'UserController@getThem');
		Route::post('them', 'UserController@postThem');

		Route::get('sua/{id}', 'UserController@getSua');
		Route::post('sua/{id}', 'UserController@postSua');


		Route::get('xoa/{id}', 'UserController@getXoa');
	});

	Route::group(['prefix'=>'ajax'], function(){
		Route::get('loaitin/{idTheLoai}', 'AjaxController@getLoaiTin');
	});
});
