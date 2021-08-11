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
    return view('auth.login');
});
Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/map', 'MapController@index')->name('map');
    //Route::get('/evacuation-centers', 'EvacuationCenterController');
    //Route::get('/map', function () {        return view('admin.map'); });
    Route::prefix('evacuation-centers')->group(function () {
        Route::get('/',         'EvacuationCenterController@index')->name('evac.index');
        Route::get('/create',   'EvacuationCenterController@create')->name('evac.create');
        Route::post('/store',   'EvacuationCenterController@store')->name('evac.store');
        Route::get('/edit',     'EvacuationCenterController@edit')->name('evac.edit');
        Route::post('/update',  'EvacuationCenterController@update')->name('evac.update');
        Route::get('/delete',   'EvacuationCenterController@delete')->name('evac.delete');
    });
});
