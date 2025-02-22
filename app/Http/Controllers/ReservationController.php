<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\DineTable;
use App\Models\Customer;

class ReservationController extends Controller
{
    public function create(){    
        
        $tables = DineTable::all();
        $reservations = Reservation::all();

        return view('reservation.create', compact('tables','reservations'));
    }

    public function store(Request $request){
        $request->validate([
            'customer'=>'required|string',
            'fullname'=> 'required|string',
            'date'=>'required|date',
            'stime'=> 'required',
            'etime'=> 'required|after:stime',
            'tableSelect'=> 'required'
        ]);

        $customer = Customer::where('username', $request->customer)->first();

        //add way to load the customer details to the view here.

        Reservation::create([
            'reserveDate'=>$request->date,
            'startTime' => $request->stime,
            'endTime' => $request->etime,
            'staffID' => session('system_user_id'),
            'tableID' => $request->tableSelect,
            'cusID' => $customer->cusID
        ]);

        return redirect()->route('host.dashboard')->with('success','Reservation added');
    }
}
