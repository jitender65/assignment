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
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('teams/get-data', 'TeamController@getData');
Route::resource('teams', 'TeamController');
Route::any('teams/{id}/players/get-data', 'PlayerController@getData');
Route::post('players', 'PlayerController@store');
Route::resource('teams.players', 'PlayerController');
