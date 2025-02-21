<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemUser;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view("auth.login");
    }

    public function login(Request $request){        
        $validated = $request->validate(['username'=>'required', 'password'=> 'required']);                

        //retrieving the user from database
        $systemUser = SystemUser::where('username', $request->username)->first(); 
        if($systemUser){
            $staff = Staff::find($systemUser->staffID);               
        }

        //user_exists and password check
        if($systemUser && Hash::check($request->password, $systemUser->password)){
            session(['system_user_id'=>$systemUser->staffID]);            
            session(['job_title'=>strtolower($staff->jobTitle)]);
            
            return redirect()->route(session('job_title').".dashboard");
        }        
        return back()->with('error', 'Invalid credentials');
    }

    // public function dashboard()
    // {        
    //     if (!session()->has('system_user_id')) {
    //         return redirect()->route('auth.login');
    //     }
        
    //     $systemUser = SystemUser::find(session('system_user_id'));

    //     return view('host.dashboard', compact('systemUser'));
    // }

    //logout
    public function logout(Request $request){
        $request->session()->flush();

        return redirect()->route('auth.login');
    }
}
