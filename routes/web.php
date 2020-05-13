<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/','UrlController@index')->name('anasayfa');
Route::get('/anasayfa','UrlController@index')->name('anasayfa');
Route::post('/kaydol','UrlController@kaydet')->name('url.kaydol');
Route::get('/lnk/{link}','UrlController@yonlendir')->name('url.yonlendir');