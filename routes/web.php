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
    return view('welcome');
});
Route::post('/register','UserController@register');
Route::post('/login','UserController@login');
Route::post('/sms','UserController@sms');
Route::post('/forgot','UserController@forgot');
Route::post('/user/edit','UserController@edit');
Route::get('/user/show','UserController@show');
Route::post('/carousel/add','CarouselController@add');
Route::delete('/carousel/del','CarouselController@del');
Route::get('/carousel/show','CarouselController@show');
Route::post('/type/add','CompetitionTypeController@add');
Route::delete('/type/del','CompetitionTypeController@del');
Route::get('/type/show','CompetitionTypeController@show');
Route::post('/desc/add','CompetitionDescController@add');
Route::post('/desc/edit','CompetitionDescController@edit');
Route::delete('/desc/del','CompetitionDescController@del');
Route::get('/desc/show','CompetitionDescController@show');
Route::get('/descs/show','CompetitionDescController@descs_show');
Route::post('/team/add','TeamController@add');
Route::post('/team/edit','TeamController@edit');
Route::delete('/team/del','TeamController@del');
Route::get('/team/show','TeamController@show');
Route::get('/teams/show','TeamController@teams_show');


Route::get('/index',function (){
    return view('admin/index');
});
Route::get('/carousel/add',function (){
    return view('admin/carousel/add');
});
Route::get('/carousel/del',function (){
    return view('admin/carousel/del');
});
Route::get('/type/add',function (){
    return view('admin/type/add');
});
Route::get('/type/del',function (){
    return view('admin/type/del');
});
Route::get('/desc/add',function (){
    return view('admin/desc/add');
});
Route::get('/desc/edit',function (){
    return view('admin/desc/edit');
});
Route::get('/desc/del',function (){
    return view('admin/desc/del');
});