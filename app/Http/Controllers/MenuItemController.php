<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder_ExtraTopping;
use App\Models\ExtraTopping;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class MenuItemController extends Controller
{
    public function view(Request $request, $id){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $item = MenuItem::find($id);
        $toppings = CustomerOrder_ExtraTopping::where('menuID', $id)->get();
        $topping = 'None';        
        try{
            $topping = ExtraTopping::find($toppings[0]->toppingID)->toppingName;
        } catch(\Exception $e){}
        
        

        // dd($toppings);

        return response()->json([
            'html' => view('menuitem.view', compact('item', 'topping'))->render(),
            'item_name' => $item->itemName,
            'topping' => $topping
            
        ]);
    }

    public function create(Request $request){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $request->validate([
            'itemName' => 'required|string|max:255',
            'size' => 'required|in:Small,Medium,Large',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'availability' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->storeAs('menu-images', $request->itemName ,'public');

        } else {
            $path = null;
        }

        try{
            MenuItem::create([
                'itemName' => $request->itemName,
                'category' => $request->category,
                'size' => $request->size,
                'price' => $request->price,
                'availability' => $request->availability,
                'image' => $path
            ]);
        } catch (\Exception $e){
            return redirect()->route('manager.menuitems')->with('error', 'Error occured');
        }

        return redirect()->route('manager.menuitems')->with('success', 'Menu Item added');


    }

    public function get(Request $request, $id){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $item = MenuItem::find($id);

        return response()->json([
            'item' => $item
        ]);
    }

    public function update(Request $request, $id){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }


        $request->validate([
            'itemName' => 'required|string|max:255',
            'size' => 'required|in:Small,Medium,Large',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'availability' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->storeAs('menu-images', $request->itemName ,'public');

        } else {
            $path = null;
        }

        $item = MenuItem::find($id);
        try{
            if ($path == null){
                $item -> update([
                    'itemName' => $request->itemName,
                    'category' => $request->category,
                    'size' => $request->size,
                    'price' => $request->price,
                    'availability' => $request->availability,                                   
                ]);
            } else {
                $item -> update([
                    'itemName' => $request->itemName,
                    'category' => $request->category,
                    'size' => $request->size,
                    'price' => $request->price,
                    'availability' => $request->availability,                
                    'image' => $path
                ]);
            }
            
        } catch(\Exception $e){
            return redirect()->route('manager.menuitems')->with('error', 'Error occured');
        }

        return redirect()->route('manager.menuitems')->with('success', 'Menu Item updated');
    }

    public function delete($id){
         //validating if the user is logged in
         if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        try{
            $item = MenuItem::find($id);
            $item->delete();            
        } catch(\Exception $e){
            return redirect()->route('manager.menuitems')->with('error', "Failed to delete");
        }

        return redirect()->route('manager.menuitems')->with('success', 'Deleted successfully');
    }
}
