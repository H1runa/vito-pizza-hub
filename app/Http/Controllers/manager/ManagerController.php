<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\CustomerOffer;
use App\Models\ExtraTopping;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard(){
        return view('manager.dashboard');
    }

    public function menu(){
        $items = MenuItem::all();

        return view('manager.menu-items', compact('items'));
    }

    public function toppings(){
        $toppings = ExtraTopping::all();

        return view('manager.toppings', compact('toppings'));
    }

    public function offers(){
        $offers = CustomerOffer::all();

        return view('manager.offers', compact('offers'));
    }
    
}
