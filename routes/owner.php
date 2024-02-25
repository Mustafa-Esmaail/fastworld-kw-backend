<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['authGuest']],function(){

    Route::post('register','RegisterController@register');
    Route::post('verifyEmailToRegister','RegisterController@verifyEmailToRegister');
    Route::post('resndVerifyCode','RegisterController@resndVerifyCode');
    Route::post('login','authenticationController@authenticate');
    // social
    Route::post('sociallogin','RegisterController@sociallogin');

    // forgetpassword
    Route::post('forgetpassword','forgetpasswordController@forgetpassword');
    Route::post('resetforgetpassword','forgetpasswordController@resetforgetpassword');



    //end forget and reset password


    Route::group(['middleware'=>'owner'],function(){

        Route::post('logout','authenticationController@logout');
        Route::get('getProfile','profileController@getProfile');
        Route::post('updateProfile','profileController@updateProfile');
        Route::post('changePassword','profileController@changePassword');
        Route::post('add_second_email','profileController@add_second_email');
        Route::post('verify_second_email','profileController@verify_second_email');
        
       //delete account 
        Route::post('deleteProfile', 'profileController@deleteProfile');
 
        Route::get('Category/all', 'CategoryController@all');
        Route::post('Category/get', 'CategoryController@get');

        // Route::get('Design/all', 'DesignController@all');
        Route::post('Design/store', 'DesignController@store');
        Route::post('Design/get', 'DesignController@get');
        
        // information
        Route::post('Information/store', 'InformationController@store');
        Route::post('Information/update', 'InformationController@update');
        Route::post('Information/delete', 'InformationController@delete');
        Route::post('Information/get', 'InformationController@get');
        

         // Content
         Route::post('Content/store', 'ContentController@store');
         Route::post('Content/update', 'ContentController@update');
         Route::post('Content/delete', 'ContentController@delete');

         
        // Button
        Route::post('Button/store', 'ButtonController@store');
        Route::post('Button/update', 'ButtonController@update');
        Route::post('Button/delete', 'ButtonController@delete');

        // Social
        Route::post('Social/store', 'SocialController@store');
        Route::post('Social/update', 'SocialController@update');
        Route::post('Social/delete', 'SocialController@delete');

        // links
        Route::get('links/MyLinks', 'LinkController@MyLinks');
        Route::post('links/update_name', 'LinkController@update_name');
        
        
        //messge 
        Route::post('SendMessage','MessageController@SendMessage');
        Route::get('getAllChats','MessageController@getAllChats');
        Route::post('deleteMessge','MessageController@deleteMessge');
        Route::get('getAllSenders','MessageController@getAllSenders');
        Route::post('getCustomChat','MessageController@getCustomChat');
        // Route::get('getMyAllChats','MessageController@getMyAllChats');

        //notifications
        Route::get('getNotifications','NotificationController@getNotifications');
        Route::post('deleteNotify','NotificationController@deleteNotify');
        Route::get('readNotification','NotificationController@readNotification');
        Route::post('sendNotify','NotificationController@sendNotify');

        //setting
        //Route::post('Setting/store','SettingController@store');
        Route::post('Setting/update','SettingController@update');
        Route::get('Setting/get','SettingController@get');

        //views
        Route::post('getviews','ViewController@getviews');

        
        // pages
        Route::post('page','PageController@page');

        // visitors
        Route::post('getvisitors','VisitorController@getvisitors');

        
    });
});

