<?php

namespace App\Http\Controllers;

use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SystemUserController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'username' => 'required|string|max:255', 
            'password' => 'required|string',             
        ]);

        try{
            $password = Hash::make($request->password);
            $id = intval($request->userType);
            // dd($id);

            SystemUser::create([
                'staffID' => $id,
                'username' => $request->username,
                'password' => $password
            ]);

            return redirect()->back()->with('success', 'System User added successfully');
        } catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get($id){
        $user = SystemUser::find($id);

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request, $id){
        try{
            $user = SystemUser::find($id);

            $password = Hash::make($request->password);

            $user->update([
                'username' => $request->username,
                'password' => $password
            ]);

            return redirect()->back()->with('success', 'Updated successfully');

        } catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete($id){
        try{
            $user = SystemUser::find($id);

            $user->delete();

            return redirect()->back()->with('success', 'Deleted successfully');
            
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to delete');
        }
    }
}
