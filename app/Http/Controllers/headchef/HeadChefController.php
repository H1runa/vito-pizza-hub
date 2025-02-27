<?php

namespace App\Http\Controllers\headchef;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use App\Models\MenuItem;

class HeadChefController extends Controller
{
    public function dashboard(){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $orders = CustomerOrder::whereIn('orderStatus', ['Placed', 'Preparing'])
                    ->with(['customer', 'menuItems'])
                    ->get();

        return view('headchef.dashboard', compact('orders'));
    }
}
