<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DineTable;

class DineTableController extends Controller
{
    public function create(){
        if(!session()->has("system_user_id")){
            return redirect()->route("auth.login");
        }
        return view('dinetable.create');
    }

    public function store(Request $request){
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
}
