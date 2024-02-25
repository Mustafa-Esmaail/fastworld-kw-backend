<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/ 
Route::post('Advice/store_Advice','AdviceController@store_Advice');
Route::post('Advice/get_Advice','AdviceController@get_Advice');
Route::get('Advice/get_all_Advice','AdviceController@get_all_Advice');

// Route::post('Advice/store_Advice','CategoryAdviceController@store_Advice');
Route::post('CategoryAdvice/get_Category','CategoryAdviceController@get_Category');
Route::get('CategoryAdvice/get_all_Category','CategoryAdviceController@get_all_Category');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('Information/get', 'InformationController@get');

// socials
Route::post('Social/get','SocialController@get');
Route::get('Social/all','SocialController@all');

// View_Link
Route::post('Link/View_Link','LinkController@View_Link');
Route::get('gettypes','GuestController@gettypes');
Route::get('get_button_link_types','GuestController@get_button_link_types');
//VarificationIcon
Route::get('getVarificationIcons','VarificationIconController@getVarificationIcons');

// Route::post('object/store','ObjectController@store');
