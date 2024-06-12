<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('attendanceform');
});
Route::get('/register', function () {
    return view('registration');
});

Route::get('/system', function () {
    return view('adminlogin');
});
Route::post('/check',[UserController::class,'userCheck']);


Route::group(['name'=>'user', 'middleware'=>'userDetail'], function(){
    Route::get('/admin', function () {
        return view('employeelist');
    });

    Route::get('/attendance', function () {
        return view('attendancelist');
    });
    

    
});
