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

    /*
     * Created By Dara on 1/2/2016
     * user profile management
     */
    Route::group(['prefix'=>'profile','as'=>'profile.','middleware'=>['auth','email']],function(){
        Route::get('/',['as'=>'me','uses'=>'ProfileController@index']);
        Route::post('/store',['as'=>'store','uses'=>'ProfileController@store']);
    });

    /**
     * Created By Dara on 4/2/2016
     * Admin routes
     */
    Route::group(['prefix'=>'admin','as'=>'admin.'],function(){
        Route::get('/',['as'=>'index','uses'=>'AdminController@index']);



        /**
         * Created By Dara on 4/2/2016
         * Article management (admin) add/edit
         */
        Route::group(['prefix'=>'article','as'=>'article.'],function(){
            Route::get('create',['as'=>'create','uses'=>'ArticleController@create']);
            Route::post('store',['as'=>'store','uses'=>'ArticleController@store']);
            Route::post('upload',['as'=>'upload','uses'=>'ArticleController@upload']);
            Route::delete('delete',['as'=>'delete','uses'=>'ArticleController@delete']);
            Route::get('edit/{article}',['as'=>'edit','uses'=>'ArticleController@edit']);
            Route::post('edit/{article}',['as'=>'update','uses'=>'ArticleController@update']);
        });

        /**
         * Created By Dara on 14/2/2016
         * category management
         */
        Route::group(['prefix'=>'category','as'=>'category.'],function(){
            Route::get('/',['as'=>'index','uses'=>'CategoryController@index']);
            Route::post('/store',['as'=>'store','uses'=>'CategoryController@store']);
            Route::get('/{category}/edit',['as'=>'edit','uses'=>'CategoryController@categoryEdit']);
            Route::put('/{category}/update',['as'=>'update','uses'=>'CategoryController@update']);
            Route::get('/{category}/delete',['as'=>'delete','uses'=>'CategoryController@delete']);
            Route::get('/{category}/sub',['as'=>'add','uses'=>'CategoryController@add']);
            Route::get('/{category}/subCategory',['as'=>'subCategory.index','uses'=>'CategoryController@subCategoryIndex']);
            Route::post('/{category}/subCategory/store',['as'=>'subCategory.store','uses'=>'CategoryController@subCategoryStore']);
            Route::get('/{category}/subCategory/{subCategory}/edit',['as'=>'subCategory.edit','uses'=>'CategoryController@subCategoryEdit']);
            Route::get('/{category}/subCategory/{subCategory}/delete',['as'=>'subCategory.delete','uses'=>'CategoryController@subCategoryDelete']);
            Route::put('/{category}/subCategory/{subCategory}/update',['as'=>'subCategory.update','uses'=>'CategoryController@subCategoryUpdate']);
        });

        /**
         * Created By Dara on 14/2/2016
         * course management
         */
        Route::group(['prefix'=>'course','as'=>'course.'],function(){
            Route::get('create',['as'=>'create','uses'=>'CourseController@create']);
            Route::post('store',['as'=>'store','uses'=>'CourseController@store']);
            Route::get('/{course}/edit',['as'=>'edit','uses'=>'CourseController@edit']);
            Route::post('/{course}/update',['as'=>'update','uses'=>'CourseController@update']);
            Route::get('/{course}/session/create',['as'=>'session.create','uses'=>'SessionController@create']);
            Route::post('/{course}/session/store',['as'=>'session.store','uses'=>'SessionController@store']);
            Route::get('/{course}/session/{session}/edit',['as'=>'session.edit','uses'=>'SessionController@edit']);
            Route::post('/{course}/session/{session}/update',['as'=>'session.update','uses'=>'SessionController@update']);
        });




    });
    /**
     * Created By Dara on 6/2/2015
     * Article management (main) show
     */
    Route::group(['prefix'=>'article','as'=>'article.'],function(){
        Route::get('/',['as'=>'index','uses'=>'ArticleController@index']);
        Route::get('/{article}',['as'=>'show','uses'=>'ArticleController@show']);
    });

    /**
     * Created By Dara on 10/2/2016
     * ajax requests on submit
     */
    Route::group(['prefix'=>'ajax','as'=>'ajax.','middleware'=>['ajax','auth']],function(){

        Route::group(['prefix'=>'article','as'=>'article.'],function(){
            Route::post('/{article}/comment/{comment_id}/store',['as'=>'comment.store','uses'=>'CommentController@article']);
        });

        Route::group(['prefix'=>'category','as'=>'category.'],function(){
            Route::get('/subCategory',['as'=>'change','uses'=>'CategoryController@getSubCategory']);
        });

        Route::group(['prefix'=>'session','as'=>'session.'],function(){
            Route::get('/{session}/attachment/{attachment}/delete',['as'=>'attachment.delete','uses'=>'SessionController@attachmentDelete']);
        });
    });


    Route::get('video/{videoName}',['as'=>'session.showVideo','uses'=>'SessionController@showVideo']);
    Route::get('file/{fileName}',['as'=>'session.showFile','uses'=>'SessionController@downloadAttachmentFile']);


});


