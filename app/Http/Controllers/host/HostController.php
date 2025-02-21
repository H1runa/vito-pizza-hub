<?php

namespace App\Http\Controllers\host;

use App\Http\Controllers\Controller;
use App\Models\DineTable;
use App\Models\Reservation;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function dashboard(){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $dineTable = DineTable::all();        
        $reservations = Reservation::with('customer')->get();

        //returning the view to be displayed
        return view("host.dashboard", compact('dineTable', 'reservations'));
    }
}
