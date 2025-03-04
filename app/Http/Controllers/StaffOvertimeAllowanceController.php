<?php

namespace App\Http\Controllers;

use App\Models\StaffOvertimeAllowance;
use Illuminate\Http\Request;

class StaffOvertimeAllowanceController extends Controller
{
    public function store(Request $request){
        try{
            StaffOvertimeAllowance::create($request->all());
            return redirect()->back()->with('success','Added');
        } catch(\Exception $e){
            return redirect()->back()->with('error','Could not add');
        }
    }

    public function delete($id){
        try{
            $ot = StaffOvertimeAllowance::find($id);

            $ot -> delete();

            return redirect()->back()->with('success','Deleted successfully');
        } catch(\Exception $e){
            return redirect()->back()->with('error','Could not delete');
        }
    }
}
