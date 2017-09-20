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

Route::get('/', function () {
    $data = [];
    $data['accesstoken'] = Request::cookie('accesstoken');
    $data['userID'] = Request::cookie('userID');
    return view('searchHome',$data);
});

Route::post('/GetMyArticles','search\GetMyArticlesController@searchArticle');
