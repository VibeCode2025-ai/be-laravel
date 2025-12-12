<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/run/storage-link', function () {
    Artisan::call('storage:link');
    return 'Link created!';
});
