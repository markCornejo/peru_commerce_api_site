<?php

use Illuminate\Http\Request;
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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['prefix' => 'v1/{lang}', 'middleware' => 'lang'], function () {

    // rutas libres
    Route::group(['prefix' => 'sites', 'middleware' => 'auth.access'], function () {
        // Route::get('{pc_sites_id}/home', 'HomeController@prueba');
        Route::get('{site}/simples', 'Admin\SiteController@simple');
    });

    // rutas admin
    Route::group(['prefix' => 'admin', 'middleware' => 'auth.access'], function () {
        Route::apiResource('sites', 'Admin\SiteController');
        Route::apiResource('sites.categorysubcategories', 'Admin\CategorySubcategoryController')->shallow();
        // Route::apiResource('sites.images', 'Admin\ImageController')->shallow()->except(['show', 'update', 'destroy']);

        Route::group(['prefix' => 'sites/{site}'], function () {
            Route::apiResource('images', 'Admin\ImageController');
            Route::put('images/{image}/cropper', 'Admin\ImageCropperController@cut'); // cortar imagen
            Route::apiResource('ubigeo', 'Admin\UbigeoController')->only(['index']);
        });

    });


    Route::group(['prefix' => 'master', 'middleware' => 'auth.access'], function () {
        Route::apiResource('salespackages', 'Master\SalesPackageController');
    });

});
