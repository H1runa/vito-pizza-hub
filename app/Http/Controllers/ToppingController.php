<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExtraTopping;

class ToppingController extends Controller
{
    public function get($id){
       $topping = ExtraTopping::find($id);

       return response()->json([
        'topping' => $topping
        ]);
        
    }

    public function create(Request $request){
        $request->validate([
            'toppingName' => 'required|string|max:255',
            'price' => 'numeric|min:0',
            'availability' => 'required'
        ]);

        try{
            $topping = ExtraTopping::create([
                'toppingName' => $request->toppingName,
                'price' => $request->price,
                'availablity' => $request->availability
            ]);
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Topping not added');
        }

        return redirect()->back()->with('success', 'Topping added successfully');
        
    }

    public function update(Request $request, $id){
        $request->validate([
            'toppingName' => 'required|string|max:255',
            'price' => 'numeric|min:0',
            'availability' => 'required'
        ]);
        try{
            $topping = ExtraTopping::find($id);
            $topping->update([
                'toppingName' => $request->toppingName,
                'price' => $request->price,
                'availablity' => $request->availability
            ]);
        } catch (\Exception $e){
            return redirect()->back()->with('error' , 'Update failed');
        }

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function delete($id){
        try{
            $topping = ExtraTopping::find($id);
            $topping->delete();
        } catch (\Exception $e){
            return redirect()->back()->with('error', $e);
        }

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
