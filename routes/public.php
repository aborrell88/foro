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

Route::get('/', [
    'uses' => 'PostController@index',
    'as' => 'posts.index'
]);

Route::get('/home', 'HomeController@index');

Route::get('posts/{post}-{slug}', [
    'uses' => 'PostController@show',
    'as' => 'posts.show'
])->where('post', '\d+');