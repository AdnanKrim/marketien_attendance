<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
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
        if (!$attend || $attend->created_at < Carbon::now()->subDays(1)->toDateTimeString()) {

            if ($user->user_ip === Request()->ip() && $user->user_device === $deviceInfo) {
                $data->user_id = $user->id;
                $data->date  = Carbon::now()->format('Y-m-d');
                $data->time = Carbon::now()->format('H:i:s');
                $data->log_type = $req->log_type;
                $data->user_ip = Request()->ip();
                $data->user_device = $deviceInfo;
                $result = $data->save();
                if ($result) {
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
        }else{
            return back()->with('fail', 'your '.$req->log_type.' has counted already for this day'); 
        }
    }
    public function employeeRegister(Request $req)
    {
        $req->validate([
            'name' => 'required|unique:employees',
            'employee_id' => 'required|unique:employees'

        ]);
        // $macAddress = $this->getMacAddress();
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
    }
    public function employeeDetail($id)
    {
        $data = Attendance::where('user_id', $id)->get();
        return view('detailattendance', ['details' => $data]);
    }
    function delete($id)
    {
        $data = Employee::find($id);
        $data->delete();
        return redirect('admin');
    }
}
