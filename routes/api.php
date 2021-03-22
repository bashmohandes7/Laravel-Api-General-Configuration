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


Route::group(['middleware'=> ['api', 'checkPassword' , 'changeLanguage'] , 'namespace'=>'Api'], function(){
    Route::post('get-main-categories', 'CategoryController@index');
    Route::post('get-category-byId', 'CategoryController@getCategoryById');
    Route::put('cahnge-category-status', 'CategoryController@changeCategoryStatus');

    Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function(){
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout')
            ->middleware('assignGuard:admin-api');
    });
    Route::group(['prefix'=>'user', 'namespace'=> 'User'], function(){
        Route::post('login', 'UserController@login');
    });
    Route::group(['prefix'=>'user', 'middleware'=>'assignGuard:user-api'], function(){
        Route::get('profile', function(){
            return 'Only user can reach Me';
        });
    });
});


Route::group(['middleware'=> ['api', 'checkPassword' , 'changeLanguage' , 'assignGuard:admin-api'] , 'namespace'=>'Api'], function(){
    Route::get('offers', 'CategoryController@index');
});
