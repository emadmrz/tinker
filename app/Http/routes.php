<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {

    Route::get('/home','HomeController@index');

    /*
     * Created By Dara on 1/2/2016
     * Email Confirmation routes
     */
    Route::get('email',['middleware'=>'auth','uses'=>'Auth\EmailController@index']);
    Route::post('email',['middleware'=>'auth','uses'=>'Auth\EmailController@resend']);
    Route::get('email/{confirmation_code}','Auth\EmailController@check');

    /*
     * Created By Dara on 31/1/2016
     * Login & Register routes
     */
    Route::get('register','Auth\AuthController@getRegister');
    Route::post('register','Auth\AuthController@register');
    Route::get('login','Auth\AuthController@getLogin');
    Route::post('login','Auth\AuthController@login');
    Route::get('logout','Auth\AuthController@logout');
    Route::post('password/email','Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset','Auth\PasswordController@reset');
    Route::get('password/reset/{token?}','Auth\PasswordController@showResetForm');

    /*
     * Created By Dara on 1/2/2016
     * Site Main page
     */
    Route::get('/',['as'=>'index','uses'=>'IndexController@index']);

    Route::group(['prefix'=>'profile','as'=>'profile.','middleware'=>['auth','email']],function(){
        Route::get('/',['as'=>'me','uses'=>'ProfileController@index']);
        Route::post('/store',['as'=>'store','uses'=>'ProfileController@store']);
    });

});
