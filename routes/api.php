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

Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
    #Crew
    Route::group(['prefix' => 'crew'], function () {
        Route::get('', 'CrewController@index');
        Route::get('{crew}', 'CrewController@show');
        Route::post('', 'CrewController@store');
        Route::put('{crew}', 'CrewController@update');
        Route::delete('{crew}', 'CrewController@delete');
    });

    #Document
    Route::group(['prefix' => 'document'], function () {
        Route::get('', 'DocumentController@index');
        Route::get('{document}', 'DocumentController@show');
        Route::post('', 'DocumentController@store');
        Route::put('{document}', 'DocumentController@update');
        Route::delete('{document}', 'DocumentController@delete');
    });

    #Ranks
    Route::group(['prefix' => 'rank'], function () {
        Route::get('', 'RankController@index');
        Route::get('{rank}', 'RankController@show');
        Route::post('', 'RankController@store');
        Route::put('{rank}', 'RankController@update');
        Route::delete('{rank}', 'RankController@delete');
    });

    #UserRole
    Route::group(['prefix' => 'role'], function () {
        Route::get('', 'RoleController@index');
        Route::get('{role}', 'RoleController@show');
        Route::post('', 'RoleController@store');
        Route::put('{role}', 'RoleController@update');
        Route::delete('{role}', 'RoleController@delete');
    });

    #Users
     Route::group(['prefix' => 'user'], function () {
        Route::get('', 'UserController@index');
        Route::get('{user}', 'UserController@show');
        Route::post('', 'UserController@store');
        Route::put('{user}', 'UserController@update');
        Route::delete('{user}', 'UserController@delete');
    });

    #Crew Document
    Route::group(['prefix' => 'crew-document'], function () {
        Route::get('', 'CrewDocumentController@index');
        Route::get('{crew_document}', 'CrewDocumentController@show');
        Route::post('', 'CrewDocumentController@store');
        Route::delete('{crew_document}', 'CrewDocumentController@delete');
    });
});




