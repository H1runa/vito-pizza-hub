<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EPF;

class EPFController extends Controller
{
    public function store(Request $request){
        
        try{
            $request->validate([                
                'date' => 'required|date',  
                'EPF_rate' => 'required|numeric|min:0',  
                'amount' => 'required|numeric|min:0',  
                'staffID' => 'required',  
            ]);

            EPF::create($request->all());

            return redirect()->back()->with('success','EPF added successfully');

            // return redirect()->back()->with('','');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Failed to add EPF');
        }
    }

    public function update(Request $request, $id){
        try{
            $request->validate([                
                'date' => 'required|date',  
                'EPF_rate' => 'required|numeric|min:0',  
                'amount' => 'required|numeric|min:0',  
                'staffID' => 'required',  
            ]);

            $epf = EPF::find($id);
            $epf->update($request->all());

            return redirect()->back()->with('success','Successfully updated');

        } catch(\Exception $e){
            return redirect()->back()->with('error','Updated failed');
        }

    }

    public function delete($id){
        try{
            $epf = EPF::find($id);

            $epf->delete();

            return redirect()->back()->with('success','Successfully deleted');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Failed to delete');
        }
    }

    public function get($id){
        $epf = EPF::find($id);

        return response()->json([
            'epf' => $epf
        ]);
    }
}
