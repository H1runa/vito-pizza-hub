<?php

namespace App\Http\Controllers;

use App\Models\StaffLeave;
use Illuminate\Http\Request;

class StaffLeaveController extends Controller
{
    public function store(Request $request){
        try{
            $request->validate([
                'staffID' => 'required',
                'leaveType' => 'required',
                'leaveDate' => 'required|date',
                'duration' => 'required|integer|min:1',
                'reason' => 'required|string|max:255',
                'deductAmount' => 'required|numeric|min:0',
                'salaryID' => 'required',
            ]);

            StaffLeave::create($request->all());

            return redirect()->back()->with('success','Successfully added leave');
            // return redirect()->back()->with('','');
        } catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function update(Request $request, $id){
        try{
            $request->validate([
                'staffID' => 'required',
                'leaveType' => 'required',
                'leaveDate' => 'required|date',
                'duration' => 'required|integer|min:1',
                'reason' => 'required|string|max:255',
                'deductAmount' => 'required|numeric|min:0',
                'salaryID' => 'required',
            ]);

            $leave = StaffLeave::find($id);
            $leave->update($request->all());

            return redirect()->back()->with('success','Successfully updated');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Failed to updated');
        }
    }

    public function delete($id){
        try{
            $leave = StaffLeave::find($id);

            $leave->delete();

            return redirect()->back()->with('success','Successfully deleted');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Failed to delete');
        }
    }

    public function get($id){
        $leave = StaffLeave::find($id);

        return response()->json([
            'leave' => $leave
        ]);
    }
}
