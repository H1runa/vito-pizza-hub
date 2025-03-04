<?php

namespace App\Http\Controllers;

use App\Models\ServiceChargeAllowance;
use Illuminate\Http\Request;

class ServiceChargeAllowanceController extends Controller
{
    public function store(Request $request){
        try{
            ServiceChargeAllowance::create($request->all());
            return redirect()->back()->with('success', 'Allowance added successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Failed to add allowance');
        }
    }

    public function delete($id){
        try{
            $serv = ServiceChargeAllowance::find($id);            
            $serv->delete();

            return redirect()->back()->with('success', 'Deleted Successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
