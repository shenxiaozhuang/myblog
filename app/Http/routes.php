<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'Home\IndexController@index');
    Route::get('/category', 'Home\IndexController@category');
    Route::get('/cate/{cat_id}', 'Home\IndexController@cate');
    Route::get('/a/{art_id}', 'Home\IndexController@article');

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    //栏目管理
    Route::resource('category', 'CategoryController');
    Route::post('cate/changeorder', 'CategoryController@changeOrder'); //栏目排序
    //文章管理
    Route::resource('article', 'ArticleController');
    //友情链接管理
    Route::resource('links', 'LinksController');
    Route::post('links/changeorder', 'LinksController@changeOrder'); //友情链接排序
    //自定义导航管理
    Route::resource('navs', 'NavsController');
    Route::post('navs/changeorder', 'NavsController@changeOrder'); //自定义导航排序
    //网站配置管理
    Route::resource('config', 'ConfigController');
    Route::post('config/changeorder', 'ConfigController@changeOrder'); //网站配置排序
    Route::post('config/changcontent', 'ConfigController@changeContent'); //更改网站配置内容
    Route::get('putfile', 'ConfigController@putFile'); //
    //上传图片
    Route::any('upload', 'CommonController@upload');
});

//显示异常消息
Route::get('test', function ()
{
    return view('test');
});