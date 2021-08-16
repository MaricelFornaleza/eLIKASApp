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

use App\Models\User;


Route::get('/', function () {
    $count = User::count();
    if ($count == 0) {
        return view('auth.register');
    } else {
        return view('auth.login');
    }
});
Route::auth('/register', function () {
    $count = User::count();
    return view('auth.register')->with('count', $count);
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::resource('/field_officers', 'FieldOfficerController');
Route::resource('/profile', 'ProfileController');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/chat', 'ChatController@index')->name('chat');
    Route::get('/chat/{id}', 'ChatController@getMessage');
    Route::post('chat', 'ChatController@sendMessage');
});