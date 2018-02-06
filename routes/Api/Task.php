<?php

Route::group(['namespace' => 'Task', 'middleware' => 'jwt.auth', 'prefix' => 'tasks/', 'as' => 'tasks.'], function () {
    Route::get('/{project_id}', 'TaskController@get_all_project_tasks')->name('get_all_project_tasks');
});

Route::group(['namespace' => 'Task', 'middleware' => 'jwt.auth', 'prefix' => 'task/', 'as' => 'tasks.'], function () {
    Route::post('', 'TaskController@add_task')->name('add_task');
    Route::get('/priorities/', 'TaskController@get_priorities')->name('get_all_project_tasks');
    Route::get('/{task_id}', 'TaskController@get_single_task')->name('get_single_task');
});
