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
//Lenguajes

Route::get('/set_language/{lang}', 'Controller@setLanguage')->name('set_language');


Route::get('/', function () {
    return view('welcome');
});

Route::get('login/{driver}', 'Auth\LoginController@redirectToProvider')->name('social_auth');
Route::get('login/{driver}/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
