<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------- |
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function() {
	return view('welcome');
});

Auth::routes();

/*パスワード再設定(user)*/

/*Userログイン後*/
Route::group(['middleware' => 'auth:user'], function() {
	Route::get('home', 'HomeController@index')->name('home');
	Route::get('item/add/cart/{id}', 'CartController@add')->name('item.add.cart');
	Route::get('item/cart', 'CartController@index')->name('cart.index');
	Route::post('item/cart/delete', 'CartController@delete')->name('item.delete');
	Route::get('cart/confirm', 'CartController@confirm')->name('cart.confirm');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function() {
	Route::get('index', 'UserController@index')->name('user.index');
	Route::get('edit/name', 'UserController@editName')->name('user.edit.name');
	Route::post('update/name', 'UserController@updateName')->name('user.update.name');
	Route::get('edit/email', 'UserController@editEmail')->name('user.edit.email');
	Route::post('send/email', 'UserController@sendEmail')->name('user.send.email');
	Route::get('update/email/{email}/{token}', 'UserController@updateEmail')->name('user.update.email');
	Route::get('edit/password', 'UserController@editPassword')->name('user.edit.password');
	Route::post('update/password', 'UserController@updatePassword')->name('user.update.password');
});

/*お問い合わせ*/
Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function() {
	Route::get('contact', 'ContactController@create')->name('content.create');
	Route::post('contact/send', 'ContactController@send')->name('content.send');
});
Route::get('contact/free', 'ContactController@createFree')->name('content.create.free');
Route::post('contact/free/send', 'ContactController@freeSend')->name('content.free.send');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::get('contact', 'Admin\ContactController@index')->name('admin.contact.index');
	Route::get('contact/detail/{id}', 'Admin\ContactController@detail')->name('admin.contact.detail');
});


/*レビュー*/
Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function() {
	Route::get('review/create/{id}', 'ReviewController@create')->name('review.create');
	Route::post('send/send', 'ReviewController@send')->name('review.send');
});

/*Admin認証不要*/
Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
	Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\LoginController@login');
});


/*Adminログイン後*/
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
	Route::get('home', 'Admin\HomeController@index')->name('admin.home');
	Route::get('item', 'Admin\ItemController@index')->name('admin.item');
	Route::get('item/detail/{id}', 'Admin\ItemController@detail')->name('admin_detail.show');
	Route::get('item/detail/edit/{id}', 'Admin\ItemController@edit')->name('item.edit');
	Route::post('item/detail/update', 'Admin\ItemController@update')->name('item.update');
	Route::get('item/add', 'Admin\ItemController@create')->name('item.create');
	Route::post('item/add', 'Admin\ItemController@add')->name('item.add');
	Route::get('item/image', 'Admin\ItemController@image')->name('item.image');
	Route::post('user/deliver_status/change/{id}', 'Admin\UserDetailController@deliverStatus')->name('deliver_status.change');
});

//ユーザーオーダー情報
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::get('user/order/detail/{id}', 'Admin\UserDetailController@orderDetail')->name('user.order.detail');
});

//ユーザー情報
route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::get('user/index', 'Admin\UserDetailController@index')->name('admin.user.index');
	Route::get('user/detail/{id}', 'Admin\UserDetailController@detail')->name('admin.user.detail');
	//csv出力
	Route::get('user/order/csv', 'Admin\UserDetailController@csvExport')->name('admin.user.order.csv');
	Route::post('user/order/csv', 'Admin\UserDetailController@csvExport')->name('admin.user.order.csv');
	Route::get('item/csv', 'Admin\ItemController@csvExport')->name('admin.item.csv');
	//csvアップロード
	Route::post('user/order/csv/upload', 'Admin\ItemController@csvUpload')->name('admin.csv.upload');
});

route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('user/order', 'Admin\UserDetailController@order')->name('admin.user.order');
	Route::get('user/order', 'Admin\UserDetailController@order')->name('admin.user.order');
});

//住所登録
Route::group(['prefix' => 'address', 'middleware' => 'auth:user'], function() {
	Route::get('/', 'Address\AddressController@index')->name('address.index');
	Route::get('create', 'Address\AddressController@create')->name('address.create');
	Route::post('add', 'Address\AddressController@add')->name('address.add');
	Route::get('edit/{id}', 'Address\AddressController@edit')->name('address.edit');
	Route::get('delete/{id}', 'Address\AddressController@delete')->name('address.delete');
	Route::post('update', 'Address\AddressController@update')->name('address.update');
	Route::get('deliver/{id}', 'Address\AddressController@deliver')->name('address.deliver');
});

Route::group(['prefix' => 'payment', 'middleware' => 'auth:user'], function() {
	Route::get('/', 'PaymentsController@index')->name('payment.index');
	Route::post('pay', 'PaymentsController@pay')->name('payment.pay');
	Route::get('address/select', 'PaymentsController@address')->name('address.select');
	Route::get('complete', 'PaymentsController@complete')->name('complete');
	Route::get('detail', 'PaymentsController@detail')->name('order.detail');
	Route::post('cancel', 'PaymentsController@cancel')->name('payment.cancel');
});

Route::get('/', 'ItemController@index')->name('user.page');
Route::get('/scraping', 'ScrapingController@index')->name('scraping.index');
Route::get('/item/detail/{id}', 'ItemController@detail')->name('detail.show');
