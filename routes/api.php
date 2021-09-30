<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('login', 'api\UserAPIController@login');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'api\UserAPIController@details');
});

Route::post('update/location', 'CourierController@update');

Route::get('/affected_residents', 'api\RestAPIController@affectedResidents');
Route::get('/barangay_residents/{barangay}', 'api\RestAPIController@barangayResidents');

Route::post('sms/inbound-sms', function () {
    if (isset($_POST) && $_POST != "") {
        $data = $_POST;
        Log::info($data);
        return response($data);
    } else {
        return response("Post empty");
    }
});