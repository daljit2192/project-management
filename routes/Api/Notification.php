<?php

Route::group(['namespace' => 'Notification', 'middleware' => 'jwt.auth', 'prefix' => 'notifications/', 'as' => 'notifications.'], function () {
    Route::get('', 'NotificationController@get_all_notifications')->name('get_all_notifications');
});
