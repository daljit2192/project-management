<?php

Route::group(['namespace' => 'Comment', 'middleware' => 'jwt.auth', 'prefix' => 'comment/', 'as' => 'comment.'], function () {
    Route::post('', 'CommentController@add_comment')->name('add_comment');
});

Route::group(['namespace' => 'Comment', 'middleware' => 'jwt.auth', 'prefix' => 'comments/', 'as' => 'comments.'], function () {
	    Route::post('', 'CommentController@get_all_comments')->name('get_all_comments');
});
