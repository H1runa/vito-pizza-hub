<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DineTable;

class DineTableController extends Controller
{
    public function create(){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
                        
            return redirect()->route("auth.login");
        }
        
        return view('dinetable.create');
    }

    public function store(Request $request){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }

        $request->validate([
            'seats'=> 'required|integer|min:1',
            'ava'=> 'required|in:True,False'
        ]);

        DineTable::create([
            'seatCount' => $request->seats,
            'availability' => $request->ava,
            'staffID' => session('system_user_id')
        ]);

        return redirect()->route('dinetable.create')->with('success','Dine Table added');

    }

    public function edit($id){

        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }

        $dineTable = DineTable::find($id);

        return view('dinetable.edit', compact('dineTable'));
    }

    public function update(Request $request, $id){

        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }

        $request->validate([
            'seats' => 'required|integer|min:1',
            'ava' => 'required|in:True,False'
        ]);

        $dineTable = DineTable::find($id);

        $dineTable->update([
            'seatCount' => $request->seats,
            'availability' => $request->ava
        ]);

        return redirect()->route('host.dashboard')->with('success', 'Dine table updated');
    }

    public function delete($id){

        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }

        $dineTable = DineTable::find($id);

        $dineTable->delete();

        return redirect()->route('host.dashboard')->with('success','Dine table deleted');
    }
}
