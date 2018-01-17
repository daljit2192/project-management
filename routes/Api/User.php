<?php

Route::group(['namespace' => 'User', 'middleware' => 'cors'], function () {
    Route::post('user', 'UserController@registerUser')->name('add');
    Route::get('user', 'UserController@register')->name('add');
    Route::post('login', 'UserController@loginUser')->name('login');
    Route::get('logout/{token}', 'UserController@logoutUser')->name('logout');
});

Route::group(['namespace' => 'User', 'middleware' => 'jwt.auth', 'prefix' => 'user/', 'as' => 'user.'], function () {
    Route::get('get', 'UserController@get_user')->name('get_user');
    Route::post('update', 'UserController@update_user')->name('get_user');
    Route::post('update/password', 'UserController@change_password')->name('change_password');
});

Route::group(['namespace' => 'User', 'middleware' => 'jwt.auth', 'prefix' => 'users/', 'as' => 'users.'], function () {
    Route::get('', 'UserController@get_all_user')->name('get_all_user');
});
