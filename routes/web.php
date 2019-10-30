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

Route::get('/', 'HomeController@landing');
Route::get('/runBash', 'HomeController@runBash');

Auth::routes();

Route::middleware('auth')->group(function(){

	Route::get('dashboard','DashboardController@index')->name('dashboard.index');

	Route::middleware('Admin')->namespace('Admin')->prefix('Admin')->group(function(){

		Route::prefix('Product')->group(function(){

			Route::get('/','ProductController@index')->name('admin.product.index');
			Route::get('create','ProductController@create')->name('admin.product.create');
			Route::get('edit/{product}','ProductController@edit')->name('admin.product.edit');
			Route::post('insert','ProductController@store')->name('admin.product.insert');
			Route::put('update','ProductController@update')->name('admin.product.update');
			Route::delete('delete','ProductController@destroy')->name('admin.product.delete');

		});

		Route::prefix('Customer')->group(function(){

			Route::get('/','CustomerController@index')->name('admin.customer.index');
			Route::get('create','CustomerController@create')->name('admin.customer.create');
			// Route::get('edit/{customer}','CustomerController@edit')->name('admin.customer.edit');
			// Route::post('insert','CustomerController@store')->name('admin.customer.insert');
			Route::put('activate','CustomerController@activate')->name('admin.customer.activate');
			Route::put('deactivate','CustomerController@deactivate')->name('admin.customer.deactivate');
			// Route::delete('delete','CustomerController@destroy')->name('admin.customer.delete');

		});

		Route::prefix('Payment')->group(function(){

			Route::get('/','PaymentController@index')->name('admin.payment.index');
			Route::post('confirm','PaymentController@confirm')->name('admin.payment.confirm');
			Route::post('decline','PaymentController@decline')->name('admin.payment.decline');

		});

		Route::prefix('Router')->group(function(){

			Route::get('/','RouterController@index')->name('admin.router.index');
			Route::get('edit/{device}','RouterController@edit')->name('admin.router.edit');
			Route::put('update','RouterController@update')->name('admin.router.update');

		});

	});

	Route::middleware('User')->namespace('User')->prefix('User')->group(function(){

		Route::prefix('Router')->group(function(){

			Route::get('/','RouterController@index')->name('user.router.index');
			Route::get('users/{router}','RouterController@users')->name('user.router.users');
			Route::get('users/{router}/online','RouterController@usersOnline')->name('user.router.users.online');
			Route::get('users/{router}/remove/{name}','RouterController@usersOnlineRemove')->name('user.router.users.remove');
			Route::get('profiles/{router}','RouterController@profiles')->name('user.router.profiles');

			Route::middleware('UserExpired')->group(function(){
				Route::get('create','RouterController@create')->name('user.router.create');
				Route::get('edit/{router}','RouterController@edit')->name('user.router.edit');
				Route::get('users/{router}/create','RouterController@createUser')->name('user.router.users.create');
				Route::get('users/{router}/edit/{name}','RouterController@editUser')->name('user.router.users.edit');
				Route::get('users/{router}/activate/{name}','RouterController@activateUser')->name('user.router.users.activate');
				Route::get('users/{router}/deactivate/{name}','RouterController@deactivateUser')->name('user.router.users.deactivate');
				Route::post('users/insert','RouterController@insertUser')->name('user.router.users.insert');
				Route::post('profiles/insert','RouterController@insertProfile')->name('user.router.profiles.insert');
				Route::put('users/update','RouterController@updateUser')->name('user.router.users.update');
				Route::get('profiles/{router}/create','RouterController@createProfile')->name('user.router.profiles.create');
				Route::get('profiles/{router}/patch/{profile}','RouterController@patchProfile')->name('user.router.profiles.patch');
				Route::get('profiles/{router}/edit/{profile}','RouterController@editProfile')->name('user.router.profiles.edit');
				Route::put('profiles/update','RouterController@updateProfile')->name('user.router.profiles.update');
				Route::post('profiles/save-patch','RouterController@savePatchProfile')->name('user.router.profiles.save-patch');
				Route::post('insert','RouterController@store')->name('user.router.insert');
				Route::put('update','RouterController@update')->name('user.router.update');
				Route::delete('delete','RouterController@destroy')->name('user.router.delete');
				Route::delete('users/delete','RouterController@destroyUser')->name('user.router.users.delete');
				Route::delete('profiles/delete','RouterController@destroyProfile')->name('user.router.profiles.delete');
			});

		});

		Route::prefix('Payment')->group(function(){

			Route::get('/','PaymentController@index')->name('user.payment.index');
			Route::get('create','PaymentController@create')->name('user.payment.create');
			Route::post('insert','PaymentController@store')->name('user.payment.insert');
			Route::put('upload','PaymentController@upload')->name('user.payment.upload');

		});

	});

	Route::get('User/last-step','User\SettingController@lastStep')->name('user.last-step');
	Route::post('User/save-last-step','User\SettingController@saveLastStep')->name('user.save-last-step');

});
