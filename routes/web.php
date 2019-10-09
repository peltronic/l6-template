<?php

Route::resource('accounts', 'AccountsController', [ ]);
Route::resource('listings', 'ListingsController', [ ]);

Route::get('/', function () {
    return view('welcome');
});
