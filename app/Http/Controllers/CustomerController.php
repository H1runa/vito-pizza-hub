<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function getFullName(Request $request){
        $request -> validate (['username'=>'required|string']);

        $customer = Customer::where('username', $request->username)->first();

        return response()->json([
            'fullName' => $customer? $customer->firstName . ' ' . $customer->lastName : ''
        ]);
    }
}
