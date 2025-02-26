<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\DineTable;
use App\Models\Customer;

class ReservationController extends Controller
{
    public function create(Request $request){   
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        } 
        
        $tables = DineTable::all();
        $reservations = Reservation::all();

        // Force JSON response even if Laravel doesn't detect AJAX properly
        if ($request->expectsJson()) {
        return response()->json([
            'html' => view('reservation.create', compact('reservations', 'tables'))->render(),
            'reservations' => $reservations,
            'tables' => $tables
        ]);
    }

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

        try{
            Reservation::create([
                'reserveDate'=>$request->date,
                'startTime' => $request->stime,
                'endTime' => $request->etime,
                'staffID' => session('system_user_id'),
                'tableID' => $request->tableSelect,
                'cusID' => $customer->cusID
            ]);
    
         }catch(\Illuminate\Validation\ValidationException $e){
            return redirect()->route('host.dashboard')->with('error', 'Inputs could not be validated');
         } catch(\Illuminate\Database\QueryException $e){
            return redirect()->route('host.dashboard')->with('error', 'Database error');
         } catch(\Exception $e){
            return redirect()->route('host.dashboard')->with('error', 'Unexpected error occurred');
         }


        return redirect()->route('host.dashboard')->with('success','Reservation added');
    }

    public function edit(Request $request, $id){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }


        $reservation = Reservation::find($id);
        $reservations = Reservation::all();
        $tables = DineTable::all();
        $customer = Customer::find($reservation->cusID);

        if($request->expectsJson()){
            return response()->json([
                'html' => view('reservation.edit', compact('reservation', 'customer', 'tables', 'reservations'))->render(),
                'reservation' => $reservation,
                'reservations' => $reservations,
                'tables' => $tables,
                'customer' => $customer
            ]);
        }
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

        try{
            $reservation->update([
                'reserveDate'=>$request->date,
                'startTime' => $request->stime,
                'endTime' => $request->etime,
                'staffID' => session('system_user_id'),
                'tableID' => $request->tableSelect,            
            ]);
        } catch (\Illuminate\Database\QueryException $e){
            return redirect()->route('host.dashboard')->with('error', 'Database error');            
        } catch (\Illuminate\Validation\ValidationException $e){
            return redirect()->route('host.dashboard')->with('error', 'Input could not be validated');
        }catch(\Exception $e){
            return redirect()->route('host.dashboard')->with('error', 'Unexpected error occurred: '.$e->getMessage());
        }
        

        //on success
        return redirect()->route('host.dashboard')->with('success','	Reservation updated');

    }

    public function delete($id){
        //code to check if the host is logged in
        if(!session()->has("system_user_id" ) || !session('job_title')=='host'){
            return redirect()->route("auth.login");
        }

        try{
            $reservation = Reservation::find($id);
            $reservation->delete();
        } catch(\Exception $e){
            return redirect()->route('host.dashboard')->with('error', 'Could not delete');
        }
        
        // on success
        return redirect()->route('host.dashboard')->with('success','Reservation deleted');
    }
}
