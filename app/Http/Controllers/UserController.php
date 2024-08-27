<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userCheck(Request $req){
        $req ->validate([
            'email'=>'required|email',
        ]);
        $user = User::where('email','=',$req->email)->first();
        if($user){
            if(Hash::check($req->password,$user->password)){
                $req->session()->put('admin',$user->id);
                return redirect('/admin');
            }
            else{
                return back()->with('fail','Invalid password');
            }
        }
        else{
            return back()->with('fail','No account for this email');
        }
    }
    public function logout(){
      if(session()->has('admin')){
        session()->pull('admin');
        return redirect('system');
      }
    }
    public function userAgent(){
        $data = Request()->userAgent();
        $user = Request()->ip();
        return response([
            'userAgent'=>$data,
            'ip'=>$user

            ]);
    }
    public function updateIp(){
        $data = Employee::all();
        foreach($data as $emp){
            $emp->user_ip = Request()->ip();
            $result = $emp->save();
        }
        if($result){
            return back()->with('success','update Ip successfully');
        }else{
            return back()->with('fail','something went wrong');
        }
    }
    public function updateAgent(Request $req){
     $data = Employee::where('id',$req->id)->first();
     $token = 'softplatoon';
     if($data->user_ip === Request()->ip() && $token === $req->token){
         $data->user_device = Request()->userAgent();
         $result = $data->save();
         if($result){
            return back()->with('success','update information successfully');
        }else{
            return back()->with('fail','something went wrong');
        }
     }else{
        return back()->with('fail','token or location is invalid');
     }

    }
}
