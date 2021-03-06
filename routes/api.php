<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'email' => 'required',
        'password' => 'required'
    ]);
    auth()->attempt($request->only('email', 'password'));
    return auth()->user();
});

Route::post('/logout', function () {
    auth()->logout();
    return response('logout');
});



Route::middleware('auth:sanctum')->post('/admin', function () {
    if (auth()->user()->role->name === 'SuperAdmin' OR auth()->user()->role->name === 'Admin') {
        return response(true);
    } else {
        return response('Not admin', 401);
    }
});

Route::namespace('Admin')->prefix('admin')->name('superAdmin.')->middleware('auth:sanctum', 'superAdmin')->group(function () {
    Route::apiResource('users', 'UserController');
    Route::apiResource('brands', 'BrandController');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('orders', 'OrderController');
    Route::apiResource('news', 'ActualityController');
    Route::delete('news/imageDelete/{id}', 'ActualityController@removeImage')->name('news.imageDelete');
    Route::post('news/addImage/{id}', 'ActualityController@addImage')->name('news.addImage');
    Route::post('news/updateActuality/{id}', 'ActualityController@updateActuality')->name('news.updateActuality');

    Route::post('news/removeNews', 'ActualityController@removeNews')->name('news.removeNews');
    Route::post('products/removeProducts', 'ProductController@removeProducts')->name('news.removeProducts');


    Route::post('brands/{id}', 'BrandController@updateBrand')->name('brands.update');
    Route::delete('brands/imageDelete/{id}', 'BrandController@removeImage')->name('brands.imageDelete');

    Route::delete('products/imageDelete/{id}', 'ProductController@removeImage')->name('products.imageDelete');
    Route::delete('products/imagesDelete/{id}', 'ProductController@removeImageFromImages')->name('products.imagesDelete');
    Route::post('products/addMainImage/{id}', 'ProductController@addImage')->name('products.addImage');
    Route::post('products/addSecondImages/{id}', 'ProductController@addImages')->name('products.addSecondImages');
    Route::post('products/updateProduct/{id}', 'ProductController@updateProduct')->name('products.updateProduct');
});


Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth:sanctum', 'allAdmin')->group(function () {
    Route::apiResource('users', 'UserController')->only(['index', 'show']);
    Route::apiResource('brands', 'BrandController')->only(['index', 'show']);
    Route::apiResource('products', 'ProductController')->only(['index', 'show']);
    Route::apiResource('news', 'ActualityController')->only(['index', 'show']);
    Route::get('productsBrand/{brandId}', 'ProductController@productsPerBrand')->name('products.perBrand');

    Route::apiResource('orders', 'OrderController')->only(['index', 'show']);
    Route::apiResource('roles', 'RoleController')->only(['index']);
    Route::get('activityLog', 'ActivityLogController@index')->name('activityLog.index');
});


Route::namespace('Client')->prefix('client')->name('client.')->group(function () {
    Route::get('products', 'ProductController@index')->name('products.index');
    Route::get('products/{slug}', 'ProductController@show')->name('products.show');
    Route::get('products/search/{search}', 'ProductController@search')->name('products.search');

    Route::get('productsBrand/{brandId}', 'ProductController@productsPerBrand')->name('products.perBrand');

    Route::get('brands', 'BrandController@index')->name('products.index');

    Route::middleware('auth:sanctum')->apiResource('addressBook', 'AddressBookController');


    Route::middleware('auth:sanctum')->post('order', 'OrderController@store')->name('orders.store');
    Route::post('order/no-account', 'OrderController@storeNoAccount')->name('orders.storeNoAccount');
    Route::get('order/{orderId}', 'OrderController@show')->name('orders.show');

    Route::get('news', 'ActualityController@index')->name('actualities.index');
    Route::get('news/{slug}', 'ActualityController@show')->name('actualities.show');

    Route::post('contact', 'ContactController@contact')->name('contact.contact');
});
