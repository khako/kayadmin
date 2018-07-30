<?php 

use Kaya\Admin\Models\User;

Route::get('/{vue_capture?}', function () {
    return view('kaya/admin::admin');
})->where('vue_capture', '[\/\w\.-]*');