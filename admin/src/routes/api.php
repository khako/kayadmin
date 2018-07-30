<?php

use Kaya\Admin\Models\User;
use Kaya\Admin\Models\BaseModel;
use Illuminate\Http\Request;

Route::get('/me', function () {
    return User::make(auth()->user());
});

Route::get('/{table}', 'BaseController@all');
Route::get('/{table}/{id}', 'BaseController@get');
Route::post('/{table}', 'BaseController@create');
Route::put('/{table}/{id}', 'BaseController@update');
Route::delete('/{table}/{id}', 'BaseController@delete');