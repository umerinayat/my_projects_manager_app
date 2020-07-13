<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Clients 
Route::get('/client/getClientDetails/{id}', 'API\ClientController@getClientDetails');
Route::get('/client/FilterClientsByProduct/{id}', 'API\ClientController@FilterClientsByProduct');


// projects
Route::get('/project/getClientProjects/{id}', 'API\ProjectController@getClientProjects');
Route::post('/project/moveProjectToClient', 'API\ProjectController@moveProjectToClient');


// TimeTracking
Route::get('/timeTracking/checkTimeStatus/{id}', 'API\TimeTrackingController@checkTimeStatus');
Route::post('/timeTracking/updateTimeStatus', 'API\TimeTrackingController@updateTimeStatus');


Route::apiResources([
    'client' => 'API\ClientController',
    'product' => 'API\ProductController',
    'project' => 'API\ProjectController',
    'TimeTracking' => 'API\TimeTrackingController'
]);
