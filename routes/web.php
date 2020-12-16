<?php
use App\Models\InvoicePrinter;
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
Route::get('teste', function(){
    return view('teste');
});
Auth::routes(['verify' => true]);
Route::redirect('home', 'user/home');
Route::get('/', function () { return view('welcome'); })->name('welcome');


Route::group(['middleware' => 'license', 'prefix' => 'admin'], function(){
    Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login');
    Route::get('login', 'Auth\AdminLoginController@showform')->name('admin.login');
    Route::get('/', 'Admin\AdminController@index')->name('admin.home');
    Route::get('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('employees', 'Admin\EmployeeController@index')->name('employee.list');
    Route::get('providers', 'Admin\ProviderController@index')->name('provider.list');
    Route::get('products', 'Admin\ProductController@index')->name('product.list');
    Route::get('stocks', 'Admin\StockController@index')->name('stock.list');
    Route::get('sales', 'Admin\SaleController@index')->name('sales.list');
    Route::get('purchases', 'Admin\PurchaseController@index')->name('purchase.list');
    Route::get('purchases/create', 'Admin\PurchaseController@create')->name('purchase.create');
    Route::get('categories', 'Admin\CategoryController@index')->name('category.list');
    Route::get('manufacturers', 'Admin\ManufacturerController@index')->name('manufacturer.list');
    Route::get('clients', 'Admin\ClientController@index')->name('clients.list');
    Route::get('notifications', 'Admin\NotificationController@index')->name('notifications');
    Route::get('settings', 'SettingController@admin')->name('admin.settings');
    Route::put('settings', 'SettingController@updateAdminPassword')->name('update.password');
});

Route::group(['middleware' => 'license', 'prefix' => 'user'], function(){
    Route::get('home', 'HomeController@index')->middleware('license')->name('home');
    Route::get('clients', 'ClientController@index')->name('client.list');
    Route::get('sales', 'SaleController@index')->name('sale.list');
    Route::get('sale', 'SaleController@create')->name('sale.create');
    Route::get('products', 'ProductController@index')->name('user.product.list');
    Route::get('settings', 'HomeController@settings')->name('settings');
    Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');
});

