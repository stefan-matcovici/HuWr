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
Auth::routes();

Route::group(['prefix' => '/'], function () {
    Route::get('/', ['as' => 'welcome', 'uses' => 'WelcomeController@index']);
    Route::get('/feed', ['as' => 'feed', 'uses' => 'WelcomeController@feed']);
    Route::get('/about', ['as' => 'about', 'uses' => 'WelcomeController@about']);
    Route::get('/country', ['as' => 'country', 'uses' => 'WelcomeController@country']);
    Route::get('/feed/get', ['as' => 'feed.get', 'uses' => 'WelcomeController@feedGet']);
});

Route::group(['prefix' => '/home'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/add', ['as' => 'add', 'uses' => 'HomeController@add']);
    Route::get('/statistics', ['as' => 'statistics', 'uses' => 'HomeController@statistics']);
    Route::get('/predictions', ['as' => 'predictions', 'uses' => 'HomeController@predictions']);
    Route::get('/profile', ['as' => 'profile', 'uses' => 'HomeController@profile']);
    Route::post('/add',['as' => 'add.migration', 'uses' => 'MigrationsController@store']);
});

Route::group(['prefix' => '/statistics'], function () {
    Route::get('/{country}/years', ['as' => 'statistics.country.years', 'uses' => 'StatisticsController@countryIndexByYears']);
});

Route::group(['prefix' => '/twitter'], function () {
    Route::get('/login', ['as' => 'twitter.login', 'uses' => 'TwitterController@twitterLogin']);
    Route::get('/callback', ['as' => 'twitter.callback', 'uses' => 'TwitterController@twitterCallback']);
    Route::get('/error', ['as' => 'twitter.error', 'uses' => 'TwitterController@twitterError']);
    Route::get('/logout', ['as' => 'twitter.logout', 'uses' => 'TwitterController@twitterLogout']);
});