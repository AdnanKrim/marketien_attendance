<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\Delay;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class EmployeeController extends Controller
{
    function getInfo()
    {

        return Request()->userAgent();
    }

    // function getMacAddress()
    // {
    //     // Command to get the MAC address
    //     $command = 'getmac';

    //     // Execute the command
    //     $result = exec($command);

    //     // Parse the result
    //     $macAddress = false;
    //     if (preg_match('/([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})/', $result, $matches)) {
    //         $macAddress = $matches[0];
    //     }

    //     return $macAddress;
    // }

    public function getDevice(Request $req)
    {

        // Employee::factory()->count(5)->create();
        $macAddress = $this->getMacAddress();
        return response([
            'macAddress' => $macAddress
        ]);
    }
    public function getAttendace(Request $req)
    {
        $req->validate([
            'name' => 'required|exists:employees,name',
            'log_type' => 'required'

        ]);
        $data = new Attendance();
        // $macAddress = $this->getMacAddress();
        $deviceInfo = Request()->userAgent();
        $user = Employee::where('name', $req->name)->first();
        $attend = Attendance::where('user_id', $user->id)->where('log_type', $req->log_type)->latest('created_at')->first();
        if (!$attend || $attend->created_at < Carbon::now()->subMinutes(900)->toDateTimeString()) {

            if ($user->user_ip === Request()->ip() && $user->user_device === $deviceInfo) {
                $data->user_id = $user->id;
                $data->date  = Carbon::now()->format('Y-m-d');
                $data->time = Carbon::now()->format('H:i:s');
                $data->log_type = $req->log_type;
                $data->user_ip = Request()->ip();
                $data->user_device = $deviceInfo;
                $result = $data->save();
                if ($result) {
                    $date = Carbon::now()->format('Y-m-d');
                    $date_format = Carbon::createFromFormat('Y-m-d', $date);
                    // $count_time = $req->created_at;
                    $count_time = Carbon::now();
                    if ($req->log_type === 'login') {
                        $spec_time_entry = Carbon::createFromTimeString('10:00:00');
                        $spec_entry = $date_format->setTimeFrom($spec_time_entry);
                        if ($count_time > $spec_entry) {

                            $entry_late = $count_time->diffInMinutes($spec_entry);
                        } else {
                            $entry_late = 0;
                        }
                        Delay::create([
                            'user_id' => $user->id,
                            'log_type' => $req->log_type,
                            'date' => $date,
                            'delay' => $entry_late
                        ]);
                    } else {
                        $spec_time_leave = Carbon::createFromTimeString('18:00:00');
                        $spec_leave = $date_format->setTimeFrom($spec_time_leave);
                        if ($count_time < $spec_leave) {

                            $leave_early = $spec_leave->diffInMinutes($count_time);
                        } else {
                            $leave_early = 0;
                        }
                        Delay::create([
                            'user_id' => $user->id,
                            'log_type' => $req->log_type,
                            'date' => $date,
                            'delay' => $leave_early
                        ]);
                    }
                    // return response('Your Attendance has counted Successfully');
                    return back()->with('success', 'Your Attendance has counted Successfully');
                } else {
                    return back()->with('fail', 'something went wrong,try again');
                    // return response('something went wrong,try again');
                }
            } else {
                return back()->with('fail', 'you are either out of registered device or out of office');
                // return response('you are either out of registered device or out of office');
            }
        } else {
            return back()->with('fail', 'your ' . $req->log_type . ' has counted already for this day');
        }
    }
    public function employeeRegister(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:employees',
            'employee_id' => 'required|unique:employees',
            'token' => 'required'

        ]);
        $token = "softplatoon";
        // $macAddress = $this->getMacAddress();
        if ($req->token === $token) {
            $data = new Employee();
            $data->name = $req->name;
            $data->employee_id = $req->employee_id;
            $data->user_ip = Request()->ip();
            $data->user_device = Request()->userAgent();
            $result = $data->save();
            if ($result) {
                return back()->with('success', 'Your Regitration has been complited');
                //  return back()->with('Your Attendance has counted Successfully');
            } else {
                // return back()->with('something went wrong,try again');
                return back()->with('fail', 'something went wrong,try again');
            }
        } else {
            return back()->with('fail', 'You are not authorized to register');
        }
    }
    public function employeeDetail($id)
    {
        $attendance = [];
        $data = Attendance::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(2);
        foreach ($data as $attend) {
            $date = $attend->date;
            $date_format = Carbon::createFromFormat('Y-m-d', $date);


            $count_time = $attend->created_at;
            if ($attend->log_type === "login") {
                $spec_time_entry = Carbon::createFromTimeString('10:00:00');
                $spec_entry = $date_format->setTimeFrom($spec_time_entry);

                if ($count_time > $spec_entry) {

                    $entry_late = $count_time->diffInMinutes($spec_entry);
                    $attend->entry_late = $entry_late;
                } else {
                    $attend->entry_late = 0;
                }
            } else {
                $spec_time_leave = Carbon::createFromTimeString('18:00:00');
                $spec_leave = $date_format->setTimeFrom($spec_time_leave);
                if ($count_time < $spec_leave) {

                    $leave_early = $spec_leave->diffInMinutes($count_time);
                    $attend->leave_early = $leave_early;
                } else {
                    $attend->leave_early = 0;
                }
            }
            // $attendance[] = $attend;
        }

        return view('detailattendance', ['details' => $data,'employee_id'=>$id]);
    }




    function delete($id)
    {
        $data = Employee::find($id);
        $data->delete();
        return redirect('admin');
    }


    public function findDateHelper(int $year, int $month)
    {

        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        $days = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day);
            $days[] = [
                'date' => $date->format('Y-m-d'),
                'weekday' => $date->format('l') // 'l' format gives full weekday name
            ];
        }

        return $days;
    }

    function excelSheet($id,$month)
    {
        $year = Carbon::now()->format('Y');
        // $month = Carbon::now()->format('m');
        // $month = Carbon::now()->subMonth()->format('m');
        // $month = 8;
        $date = Carbon::createFromFormat('!m', $month);
        // $mName = Carbon::now()->subMonth()->format('F');
        $mName = $date->format('F');
        $emp = Employee::find($id);
        $daysInMonth = $this->findDateHelper($year, $month);
        foreach ($daysInMonth as &$day) { // Use &$day to modify the original array elements
            $data = Attendance::where('user_id', $id)
                ->where('date', $day['date']) // Access 'date' as array key
                ->get();
                $day['login'] = null;
                $day['login_delay'] = null;
                $day['logout'] = null;
                $day['logout_early'] = null;

            if ($data) {


                foreach ($data as $type) {
                    $delay = Delay::where('user_id', $id)
                        ->where('date', $type->date)
                        ->where('log_type', $type->log_type)
                        ->first();

                    if ($type->log_type === 'login') {

                        $day['login'] = $type->time;
                        $day['login_delay'] = $delay->delay;
                    }
                    if ($type->log_type === 'logout') {
                        $day['logout'] = $type->time;
                        $day['logout_early'] = $delay->delay;
                    }
                }
            }
        }
        return view('attendanceSheet',
         [
            'attendance' => $daysInMonth,
            'employee' => $emp,
            'month'  => $mName,
            'issue_date'=>date('Y-m-d')


         ]);
        // return response([
        //     'attendence' => $daysInMonth,
        //     'employee' => $emp,
        //     'month'  => $mName
        // ]);
    }
}
