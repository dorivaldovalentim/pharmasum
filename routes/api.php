<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('employees', 'Api\EmployeeController@list')->name('employee.list');
Route::post('employee/store', 'Api\EmployeeController@store')->name('employee.store');
Route::get('employee/edit/{id}', 'Api\EmployeeController@edit')->name('employee.edit');
Route::put('employee/update/{id}', 'Api\EmployeeController@update')->name('employee.update');
Route::delete('employee/destroy/{id}', 'Api\EmployeeController@destroy')->name('employee.destroy');

Route::get('notifications', 'Api\NotificationController@list')->name('notification.list');
Route::put('notification/update/{id}', 'Api\NotificationController@update')->name('notification.update');
Route::delete('notification/destroy/{id}', 'Api\NotificationController@destroy')->name('notification.destroy');

Route::get('clients', 'Api\ClientController@list')->name('client.list');
Route::post('client/store', 'Api\ClientController@store')->name('client.store');
Route::get('client/edit/{id}', 'Api\ClientController@edit')->name('client.edit');
Route::put('client/update/{id}', 'Api\ClientController@update')->name('client.update');
Route::delete('client/destroy/{id}', 'Api\ClientController@destroy')->name('client.destroy');

Route::get('providers', 'Api\ProviderController@list')->name('provider.list');
Route::post('provider/store', 'Api\ProviderController@store')->name('provider.store');
Route::get('provider/edit/{id}', 'Api\ProviderController@edit')->name('provider.edit');
Route::put('provider/update/{id}', 'Api\ProviderController@update')->name('provider.update');
Route::delete('provider/destroy/{id}', 'Api\ProviderController@destroy')->name('provider.destroy');

Route::get('categories', 'Api\CategoryController@list')->name('category.list');
Route::post('category/store', 'Api\CategoryController@store')->name('category.store');
Route::get('category/edit/{id}', 'Api\CategoryController@edit')->name('category.edit');
Route::put('category/update/{id}', 'Api\CategoryController@update')->name('category.update');
Route::delete('category/destroy/{id}', 'Api\CategoryController@destroy')->name('category.destroy');

Route::get('manufacturers', 'Api\ManufacturerController@list')->name('manufacturer.list');
Route::post('manufacturer/store', 'Api\ManufacturerController@store')->name('manufacturer.store');
Route::get('manufacturer/edit/{id}', 'Api\ManufacturerController@edit')->name('manufacturer.edit');
Route::put('manufacturer/update/{id}', 'Api\ManufacturerController@update')->name('manufacturer.update');
Route::delete('manufacturer/destroy/{id}', 'Api\ManufacturerController@destroy')->name('manufacturer.destroy');

Route::get('products', 'Api\ProductController@list')->name('product.list');
Route::get('products-to-sale', 'Api\ProductController@listProductsToSale')->name('product.list');
Route::post('product/store', 'Api\ProductController@store')->name('product.store');
Route::get('product/edit/{id}', 'Api\ProductController@edit')->name('product.edit');
Route::put('product/update/{id}', 'Api\ProductController@update')->name('product.update');
Route::delete('product/destroy/{id}', 'Api\ProductController@destroy')->name('product.destroy');

Route::get('sales', 'Api\SaleController@sales')->name('sale.list');
Route::get('user/{id}/sales', 'Api\SaleController@list')->name('sale.list');
Route::post('sale/store', 'Api\SaleController@store')->name('sale.store');
Route::get('sale/show/{id}', 'Api\SaleController@show')->name('sale.show');
Route::put('sale/update/{id}', 'Api\SaleController@update')->name('sale.update');
Route::delete('sale/destroy/{id}', 'Api\SaleController@destroy')->name('sale.destroy');


Route::get('purchases', 'Api\PurchaseController@list')->name('purchases.list');
Route::get('purchase/show/{id}', 'Api\PurchaseController@show')->name('purchases.list');
Route::post('purchase/store', 'Api\PurchaseController@store')->name('purchase.store');

Route::get('stocks', 'Api\StockController@list')->name('stock.list');
Route::post('stock/store', 'Api\StockController@store')->name('stock.store');
Route::post('stock/add', 'Api\StockController@add')->name('stock.add');
Route::put('stock/reduce', 'Api\StockController@reduce')->name('stock.reduce');
Route::put('stock/update', 'Api\StockController@update')->name('stock.update');
Route::delete('stock/destroy/{id}', 'Api\StockController@destroy')->name('stock.destroy');

Route::get('profile/{id}', 'Api\SettingController@userData')->name('user.data');
Route::put('profile/update/{id}', 'Api\SettingController@updateUser')->name('user.update');
Route::put('profile/update-password/{id}', 'Api\SettingController@updateUserPassword')->name('user.update.password');