<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    public function store(Request $request){
        $request->validate([            
            'firstName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'jobTitle' => ['required', 'string', 'max:50'],
            'DOB' => ['required', 'date', 'before:today'],
            'NIC' => ['required', 'string', 'max:12'],
            'addressLine1' => ['required', 'string', 'max:100'],
            'addressLine2' => ['nullable', 'string', 'max:100'],
            'addressLine3' => ['nullable', 'string', 'max:100'],
        ]);

        try{
            Staff::create($request->all());
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Staff member could not be added');
        }

        return redirect()->back()->with('success', 'Staff member added successfully');
    }

    public function get($id){
        $staff = Staff::find($id);

        return response()->json([
            'staff' => $staff
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([            
            'firstName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'jobTitle' => ['required', 'string', 'max:50'],
            'DOB' => ['required', 'date', 'before:today'],
            'NIC' => ['required', 'string', 'max:12'],
            'addressLine1' => ['required', 'string', 'max:100'],
            'addressLine2' => ['nullable', 'string', 'max:100'],
            'addressLine3' => ['nullable', 'string', 'max:100'],
        ]);

        try {
            $staff = Staff::find($id);
            $staff->update($request->all());
            return redirect()->back()->with('success', 'Staff updated successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Staff could not be updated');
        }
    }

    public function delete($id){
        try{
            $staff = Staff::find($id);
            $staff->delete();

            return redirect()->back()->with('success', 'Successfully deleted');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to delete');
        }
    }
}
