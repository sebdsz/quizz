<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|

|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    //Route::auth();
    Route::pattern('id', '[0-9]+');
    Route::pattern('slug', '[a-z0-9-]+');
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@logout');


    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', function () {
            return redirect('quizz');
        });
        Route::get('quizz/{slug?}', 'FrontController@index');
        route::post('answer/{id}', 'FrontController@answer');
        route::post('multipleAnswers/{id}', 'FrontController@multipleAnswers');
    });

    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('resultats', 'ResultController@index');
        Route::get('questions/theme/{slug}', 'QuestionController@byTheme');
        Route::resource('questions', 'QuestionController');
        Route::resource('themes', 'ThemeController');
        Route::post('addAnswer', 'QuestionController@addAnswer');
        Route::post('deleteAnswer/{id}', 'QuestionController@deleteAnswer');

    });

});
