<?php

Route::group(['namespace' => 'Notification', 'prefix' => 'notifications/', 'as' => 'notifications.','middleware'=> ['cors']], function () {
    Route::get('', 'NotificationController@get_all_notifications')->name('get_all_notifications');
});
