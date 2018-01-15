<?php

Route::group(['namespace' => 'Project', 'middleware' => 'jwt.auth', 'prefix' => 'project/', 'as' => 'project.'], function () {
    Route::post('', 'ProjectController@create_project')->name('create_project');
    Route::get('/handle/{project_name}', 'ProjectController@get_project_handle')->name('get_project_handle');
});
