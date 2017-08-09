<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'shopify'] , function(){

	Route::get('access' , 'ShopifyController@access')->name('shopify.access');
	Route::get('callback' , 'ShopifyController@callback')->name('shopify.callback');
	Route::post('webhook/app_uninstall' , 'WebhookController@app_uninstall');

});