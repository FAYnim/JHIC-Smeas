<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pusat-karir', function () {
    return view('pusat-karir.pusat-karir');
})->name('pusat-karir.index');
