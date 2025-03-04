<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ETF;

class ETFController extends Controller
{
    public function store(Request $request){
        
        try{
            $request->validate([                
                'date' => 'required|date',  
                'ETF_rate' => 'required|numeric|min:0',  
                'amount' => 'required|numeric|min:0',  
                'staffID' => 'required',  
            ]);

            ETF::create($request->all());

            return redirect()->back()->with('success','ETF added successfully');

            // return redirect()->back()->with('','');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Failed to add ETF');
        }
    }

    public function update(Request $request, $id){
        try{
            $request->validate([                
                'date' => 'required|date',  
                'ETF_rate' => 'required|numeric|min:0',  
                'amount' => 'required|numeric|min:0',  
                'staffID' => 'required',  
            ]);

            $etf = ETF::find($id);
            $etf->update($request->all());

            return redirect()->back()->with('success','Successfully updated');

        } catch(\Exception $e){
            return redirect()->back()->with('error','Updated failed');
        }

    }

    public function delete($id){
        try{
            $etf = ETF::find($id);

            $etf->delete();

            return redirect()->back()->with('success','Successfully deleted');
        } catch (\Exception $e){
            return redirect()->back()->with('error','Failed to delete');
        }
    }

    public function get($id){
        $etf = ETF::find($id);

        return response()->json([
            'etf' => $etf
        ]);
    }
}
