<?php 

Route::get('/admin/{vue_capture?}', function () {
    return view('kaya/admin::admin');
})->where('vue_capture', '[\/\w\.-]*');