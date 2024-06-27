<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Facades\Artisan;

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
    $data = Employee::select('name')->get();
    return view('attendanceform',['names'=>$data]);
});
Route::get('/register', function () {
    return view('registration');
});

Route::get('/system', function () {
    return view('adminlogin');
});
Route::post('/check',[UserController::class,'userCheck']);
Route::post('/employee-register',[EmployeeController::class,'employeeRegister']);
Route::post('/get-attendance',[EmployeeController::class,'getAttendace']);


Route::group(['name'=>'user', 'middleware'=>'userDetail'], function(){
    Route::get('logout',[UserController::class,'logout']);
    Route::get('/admin', function () {
        $data = Employee::all();
        return view('employeelist',['employee'=>$data]);
    });
    Route::get('/detail/{id}',[EmployeeController::class,'employeeDetail']);
    // Route::get('/detail/{id}', [EmployeeController::class, 'employeeDetail'])->name('attendance.filter');
    Route::get('/delete/{id}',[EmployeeController::class,'delete']);

    Route::get('/attendance', function () {
        $data = Attendance::orderBy('created_at', 'desc')->paginate(5);
        return view('attendancelist',['attends'=>$data]);
    });



});
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('optimize:clear');
    return "cache cleared";
});

