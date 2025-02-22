<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\DineTable;
use App\Models\Customer;

class ReservationController extends Controller
{
    public function create(){   
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        } 
        
        $tables = DineTable::all();
        $reservations = Reservation::all();

        return view('reservation.create', compact('tables','reservations'));
    }

    public function store(Request $request){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }

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

    public function edit($id){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }


        $reservation = Reservation::find($id);
        $reservations = Reservation::all();
        $tables = DineTable::all();
        $customer = Customer::find($reservation->cusID);

        

        return view('reservation.edit', compact('reservation', 'customer', 'tables', 'reservations'));
    }

    public function update(Request $request, $id){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }


        $request->validate([            
            'customer'=> 'required|string',
            'date'=>'required|date',
            'stime'=> 'required',
            'etime'=> 'required|after:stime',
            'tableSelect'=> 'required'
        ]);
        

        $reservation = Reservation::find($id);

        $reservation->update([
            'reserveDate'=>$request->date,
            'startTime' => $request->stime,
            'endTime' => $request->etime,
            'staffID' => session('system_user_id'),
            'tableID' => $request->tableSelect,            
        ]);


        return redirect()->route('host.dashboard')->with('success','	Reservation updated');

    }

    public function delete($id){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }

        $reservation = Reservation::find($id);
        $reservation->delete();
        return redirect()->route('host.dashboard')->with('success','Reservation deleted');
    }
}
