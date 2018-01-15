<?php
Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
	Route::post('register', 'UserController@registerUser')->name('register');
	Route::post('login', 'UserController@loginUser')->name('login');
});
Route::group(['middleware' => 'auth'], function () {
	Route::group(['namespace' => 'User', 'prefix' => 'user/',], function () {
	    Route::get('dashboard', 'UserController@home')->name('home');
	    Route::get('dashboard/projects', 'UserController@showProjects')->name('home');
	});
});
