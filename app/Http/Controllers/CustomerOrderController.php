<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function edit(Request $request, $id){
        $order = CustomerOrder::find($id);

        return response()->json([
            'html' => view('headchef.edit-status', compact('order'))->render(),
            //'order' => $order
        ]);

        //return view('headchef.edit-status', compact('order'))->render();
    }

    public function update(Request $request, $id){
        $order = CustomerOrder::find($id);

        try{
            $order->update([
                'orderStatus' => $request->input('options-outlined')
            ]);
        } catch(\Exception $e) {
            return redirect()->route('headchef.dashboard')->with('error', 'Update failed');
        }

        return redirect()->route('headchef.dashboard')->with('success', 'Updated Successfully');
    }

    public function viewMenuItems(Request $request, $id){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }
        
        $order = CustomerOrder::with(['customer', 'menuItems'])->find($id);                    
        $items = $order->menuItems;

        return response()->json([
            'html' => view('headchef.view-item-list', compact('order', 'items'))->render(),
            'order' => $order,
            'items' => $items
        ]);
        
    }
}
