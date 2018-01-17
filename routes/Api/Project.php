<?php

Route::group(['namespace' => 'Project', 'middleware' => 'jwt.auth', 'prefix' => 'project/', 'as' => 'project.'], function () {
    Route::post('', 'ProjectController@create_project')->name('create_project');
    Route::post('/update', 'ProjectController@update_project')->name('update_project');
    Route::get('/handle/{project_name}', 'ProjectController@get_project_handle')->name('get_project_handle');
    Route::get('/{handle}/', 'ProjectController@get_single_project')->name('get_single_project');
});

Route::group(['namespace' => 'Project', 'middleware' => 'jwt.auth', 'prefix' => 'projects/', 'as' => 'projects.'], function () {
    Route::get('', 'ProjectController@get_all_user_projects')->name('get_all_user_projects');
});
