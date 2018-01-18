<?php

Route::group(['namespace' => 'Status', 'middleware' => 'jwt.auth', 'prefix' => 'statuses/', 'as' => 'statuses.'], function () {
    Route::get('', 'StatusController@get_all_statuses')->name('get_all_statuses');
});