<?php

namespace App\Http\Controllers;

use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request, $id){
        try{
            $sysuser = SystemUser::find($id);
        } catch(\Exception $e) {
            return redirect()->route('host.dashboard')->with('error', 'System User not found');
        }

        if($request->expectsJson()){
            return response()->json([
                'html' => view('profile.edit', compact('sysuser'))->with('success', 'Profile Retrieved')->render(),
                'sysuser' => $sysuser
            ]);
        }
        
        
        

    }

    public function update(Request $request, $id){

        
        try{
            $user = SystemUser::find($id);
            if ($request->filled('newpassword')){
                if(Hash::check($request->oldpassword, $user->password)){
                    $user->update([
                        'username' => $request->username,
                        'password' => Hash::make($request->newpassword)
                    ]);
                } else {
                    return redirect()->route('host.dashboard')->with('error', 'Invalid Password');
                }
            } else {
                $user->update([
                    'username' => $request->username
                ]);
            }
        } catch(\Exception $e){
            return redirect()->route('host.dashboard')->with('error', 'Profile could not be updated: '.$e->getMessage());
        }

        //on success
        return redirect()->route('host.dashboard')->with('success', 'Successfully updated profile');
    }
}
