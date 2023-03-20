<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('enrollments', 'App\Http\Controllers\Api\Enrollment\ListController');
Route::post('enrollment', 'App\Http\Controllers\Api\Enrollment\StoreController');
Route::put('enrollment', 'App\Http\Controllers\Api\Enrollment\UpdateController');
Route::delete('enrollment', 'App\Http\Controllers\Api\Enrollment\DeleteController');


Route::get('courses', 'App\Http\Controllers\Api\CourseController');
Route::get('users', 'App\Http\Controllers\Api\UserController');
