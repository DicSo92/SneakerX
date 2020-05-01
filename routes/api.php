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
    if (auth()->user()->is_admin) {
        return response(true);
    } else {
        return response('Not admin', 401);
    }
});

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth:sanctum', 'admin')->group(function () {
    Route::apiResource('users', 'UserController');
    Route::apiResource('brands', 'BrandController');
    Route::apiResource('products', 'ProductController');

    Route::post('brands/{id}', 'BrandController@updateBrand')->name('brands.update');
    Route::delete('brands/imageDelete/{id}', 'BrandController@removeImage')->name('brands.imageDelete');
});
