<?php

namespace App\Http\Controllers;

use App\Models\StaffAttendance;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    public function store(Request $request){
        try{
            $request->validate([
                'date' => 'required|date',
                'checkInTime' => 'nullable|date_format:H:i',
                'checkOutTime' => 'nullable|date_format:H:i|after:checkInTime',
                'attendanceStatus' => 'required|in:Attended,Absent',
                'staffID' => 'required',
            ]);

            StaffAttendance::create($request->all());
            return redirect()->back()->with('success','Successfully marked attendace');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Failed to mark attendace');
        }
        // return redirect()->back()->with('','');
    }


    public function delete($id){
        try{
            $att = StaffAttendance::find($id);
            $att->delete();

            return redirect()->back()->with('success','Deleted Successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Could not delete');
        }

    }

    public function get($id){
        $att = StaffAttendance::find($id);

        return response()->json([
            'attendance' => $att
        ]);

    }
}
