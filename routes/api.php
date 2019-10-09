<?php

use Illuminate\Http\Request;

Route::resource('accounts', 'AccountsController', [ 
    'only' => ['index'],
]);

Route::resource('listings', 'ListingsController', [ 
    'only' => ['index'],
]);

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */
