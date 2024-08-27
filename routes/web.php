<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

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
    return view('attendanceform', ['names' => $data]);
});
Route::get('/register', function () {
    return view('registration');
});
Route::get('/update-form', function () {
    $data = Employee::all();
    return view('updateAgent',['names' => $data]);
});
Route::post('/update-agent',[UserController::class,'updateAgent']);

Route::get('/system', function () {
    return view('adminlogin');
});
Route::get('/user-agent',[UserController::class,'userAgent']);
Route::post('/check', [UserController::class, 'userCheck']);
Route::post('/employee-register', [EmployeeController::class, 'employeeRegister']);
Route::post('/get-attendance', [EmployeeController::class, 'getAttendace']);


Route::group(['name' => 'user', 'middleware' => 'userDetail'], function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('/admin', function () {

        $data = Employee::all();
        foreach ($data as $emp) {
            $attend = Attendance::where('user_id', $emp->id)->where('log_type', '=', 'login')->latest('created_at')->first();
            $leave = Attendance::where('user_id', $emp->id)->where('log_type', '=', 'logout')->latest('created_at')->first();
            $date = Carbon::now()->format('Y-m-d');
             if($attend){
                 $att_date = $attend->created_at->format('Y-m-d');
                 if ($date === $att_date) {
                     $emp->present = 1;
                 } else {
                     $emp->present = 0;
                 }

             } else{
                $emp->present = null;
             }
             if($leave){
                 $leave_date = $leave->created_at->format('Y-m-d');
                 if ($date === $leave_date) {
                     $emp->leave = 1;
                 } else {
                     $emp->leave = 0;
                 }

             }else{
                $emp->leave = null;
             }

            }

        return view('employeelist', ['employee' => $data,]);
    });
    Route::get('/detail/{id}', [EmployeeController::class, 'employeeDetail']);
    // Route::get('/detail/{id}', [EmployeeController::class, 'employeeDetail'])->name('attendance.filter');
    Route::get('/delete/{id}', [EmployeeController::class, 'delete']);

    Route::get('/attendance', function () {
        $data = Attendance::orderBy('created_at', 'desc')->paginate(5);
        return view('attendancelist', ['attends' => $data]);
    });
    Route::get('/excel-sheet/{id}/{month}',[EmployeeController::class,'excelSheet']);
    Route::get('/update-ip',[UserController::class,'updateIp']);

});
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('optimize:clear');
    return "cache cleared";
});
