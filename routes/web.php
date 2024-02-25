<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Auth::routes();
// Route::model('user', 'User');

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'cach clear success';
});


Route::get('/', function () {
    return view('auth.login');
});

Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {

        Route::get('/dashboard/home', 'HomeController@index')->name('dashboard.home')->middleware('admin');
        Route::prefix('dashboard')->namespace('Dashboard')->middleware(['auth', 'admin'])->name('dashboard.')->group(function () {
            Route::resource('categories', 'CategoryController');
            Route::resource('users', 'UserController');
            Route::resource('roles', 'RoleController');

            Route::resource('owners', 'StudentController');
            //
            Route::post('toggelVerifyStudent/{id}','StudentController@toggelVerify')->name('toggelVerifyStudent');
            //
            Route::resource('teachers', 'TeacherController');
            //
            Route::post('toggelVerifyTeacher/{id}','TeacherController@toggelVerify')->name('toggelVerifyTeacher');
            //

            Route::resource('settings', 'SettingController')->except(['create', 'store']);
            
            Route::resource('lessons', 'LessonController');
            // Route::resource('live_broadcasts','LiveBroadcastController');
            Route::resource('lives','LiveBroadcastController');
            
            
            Route::resource('messages', 'MessageController')->except('create');
            Route::resource('notifications', 'NotificationController')->except(['destroy', 'update']);
        });
    }
);
