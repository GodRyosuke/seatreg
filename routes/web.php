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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('ssologin', 'Auth\LoginController@ssoLogin')->name('ssologin');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');

Route::post('buildings/upload', 'BuildingController@bulkStore')->name('buildings.upload');
Route::get('buildings/download', 'BuildingController@csvDownload')->name('buildings.download');
Route::resource('buildings', 'BuildingController');

Route::post('rooms/upload', 'RoomController@bulkStore')->name('rooms.upload');
Route::get('rooms/download', 'RoomController@csvDownload')->name('rooms.download');
Route::post('rooms/{room}/seatassign', 'RoomController@seatAssign')->name('rooms.seatassign');
Route::get('rooms/{room}/download_seats', 'RoomController@downloadSeats')->name('rooms.download_seats');
Route::resource('rooms', 'RoomController');

Route::get('reg/{seat_code}', 'SeatController@registSeat')->name('seats.regist_seat');

Route::post('user/assign_roles', 'UserController@assignRoles')->name('users.assign_roles');