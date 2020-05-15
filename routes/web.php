<?php

use Illuminate\Support\Facades\Auth;
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


//Auth::routes();


Route::get('/login', 'UserController@giris_form')->name('login');
Route::post('/login','UserController@giris')->name('user.giris');


Route::group(['middleware' => ['auth']],function(){

    Route::get('/home','UrlController@list')->name('home');
    Route::post('/home','UrlController@list')->name('dashboard.home');
    Route::get('/oturumukapat','UserController@oturumukapat')->name('user.oturumukapat');
    Route::get('/guncelle','UrlController@userUpdate_form')->name('userguncel');
    Route::post('/guncelle','UrlController@userUpdate')->name('userguncel.post');
    });
     