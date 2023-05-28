<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/prob', function () {
    return view('prob');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::match(['get', 'post'], '/addtask', ['as' => 'addtask', 'uses' => 'App\Http\Controllers\TaskController@addtask']);//updatetask
Route::match(['get', 'post'], '/updatetask', ['as' => 'updatetask', 'uses' => 'App\Http\Controllers\TaskController@update']);//oneentry
Route::match(['get', 'post'], '/oneentry', ['as' => 'oneentry', 'uses' => 'App\Http\Controllers\TaskController@oneentry']);//oneentry
Route::match(['get', 'post'], '/perenos', ['as' => 'perenos', 'uses' => 'App\Http\Controllers\PerenosController@perenos']);//oneentry
Route::match(['get', 'post'], '/updatestudent', ['as' => 'updatestudent', 'uses' => 'App\Http\Controllers\HomeController@updatestudent']);//получение данных о зарегистрированном пользователе
Route::match(['get', 'post'], '/exit', ['as' => 'exit', 'uses' => 'App\Http\Controllers\HomeController@exit']);//выход из личного кабинета
Route::match(['get', 'post'], '/starttest', ['as' => 'starttest', 'uses' => 'App\Http\Controllers\TestController@starttest']);//начало выполнения теста
Route::match(['get', 'post'], '/radioclic', ['as' => 'radioclic', 'uses' => 'App\Http\Controllers\TestController@radioclic']);//при нажатии на радокнопку
Route::match(['get', 'post'], '/next', ['as' => 'next', 'uses' => 'App\Http\Controllers\TestController@next']);//при нажатии кнопки следующий
Route::match(['get', 'post'], '/checkanswer', ['as' => 'checkanswer', 'uses' => 'App\Http\Controllers\TestController@checkanswer']);//при check форме
Route::match(['get', 'post'], '/textansver', ['as' => 'textansver', 'uses' => 'App\Http\Controllers\TestController@textansver']);//при работе на тексовой форма
Route::match(['get', 'post'], '/resulttest', ['as' => 'resulttest', 'uses' => 'App\Http\Controllers\TestController@resulttest']);//результат теста
