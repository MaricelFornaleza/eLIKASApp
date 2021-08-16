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

use App\Http\Controllers\FieldOfficerController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\InventoryController;

Route::get('/', function () {
    $count = User::count();
    if ($count == 0) {
        return view('auth.register');
    } else {
        return view('auth.login');
    }
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
Route::resource('supplies', 'SupplyController');
Route::resource('inventory', 'InventoryController');