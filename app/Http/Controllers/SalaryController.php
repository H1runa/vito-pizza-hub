<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;

class SalaryController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'baseSalary' => 'required|numeric|min:0',
            'fixedAllowance' => 'required|numeric|min:0',
            'netSalary' => 'required|numeric|min:0',
            'dateIssued' => 'required|date',
            'staffID' => 'required'
        ]);

        try{
            Salary::create($request->all());

            return redirect()->back()->with('success', 'Salary added successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function get($id){
        $salary = Salary::find($id);

        return response()->json([
            'salary'=> $salary
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'baseSalary' => 'required|numeric|min:0',
            'fixedAllowance' => 'required|numeric|min:0',
            'netSalary' => 'required|numeric|min:0',
            'dateIssued' => 'required|date',
            'staffID' => 'required'
        ]);

        try{
            $salary = Salary::find($id);

            $salary->update($request->all());

            return redirect()->back()->with('success', 'Updated Successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Updated Failed');
        }
    }

    public function delete($id){
        try{
            $salary = Salary::find($id);
            $salary->delete();

            return redirect()->back()->with('success', 'Deleted successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Failed to delete');
        }
    }
}
