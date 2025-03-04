<?php

namespace App\Http\Controllers\cashier;

use App\Models\CustomerOrder;
use App\Models\CustomerOrder_ExtraTopping;
use App\Models\CustomerOrder_MenuItem;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\CustomerInvoice;
use App\Models\CustomerOffer;
use App\Models\ExtraTopping;
use Illuminate\Http\Request;
use App\Models\MenuItem;

class CashierController extends Controller
{
    
    public function dashboard(){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $items = MenuItem::all();
        $categories = MenuItem::select('category')->distinct()->get();

        return view('cashier.dashboard', compact('items', 'categories'));
    }

    public function selectQuantity(Request $request, $id){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $item = MenuItem::find($id);
        $toppings = ExtraTopping::where('availablity', 'True')->get();

        return response()->json([
            'html' => view('cashier.add-menuitem', compact('item', 'toppings'))->render(),
            'item' => $item,
            'toppings' => $toppings
        ]);
    }

    public function order(Request $request){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $order = json_decode($request->orderData, true);
        $toppings = ExtraTopping::all();      

        $data = [];

        if (!$order){
            $order = [];
        }

        $index = 0;

        foreach($order as $o){     
            $selectedTopping = ExtraTopping::find($o['top']);       
            $item = MenuItem::find($o['id']);

            if($item){
                $data[$index] = [
                    'index' => $index,
                    'menuID' => $item->menuID,
                    'itemName' => $item->itemName,
                    'category' => $item->category,                    
                    'price' => $item->price,
                    'availability' => $item->availability,
                    'image' => $item->image,
                    'quantity' => $o['quantity'],
                    'topping' => $o['top'],
                    'toppingPrice' => $selectedTopping->price
                    
                ];
                $index++;
            }
        }
        

        return view('cashier.view-order', compact('data', 'toppings'));
    }

    public function offers(Request $request){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $offers = CustomerOffer::all();

        return view('cashier.view-offers', compact('offers'));
    }

    public function checkout(Request $request){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $order = $request->input('orders');        
        $offers = $request->input('offers'); 
        $tax = $request->input('tax');
        $servCharge = $request->input('servCharge');   
        $discounted = $request->input('discounted');    
        
        // dd($discounted);

        $order = json_decode($order);
        $offers = json_decode($offers);

        $orders = [];

        if($order==null){
            return redirect()->route('cashier.dashboard')->with('error', 'No items in order');
        }

        foreach ($order as $item) {
            // dd($item);
            $i = MenuItem::find($item->id);     
            $t = ExtraTopping::find($item->top);            

            $add = new \stdClass();
            $add->itemID = $i->menuID;
            $add->itemName = $i->itemName;
            $add->itemPrice = $i->price;
            $add->toppingID = $t->toppingID;
            $add->toppingName = $t->toppingName;
            $add->toppingPrice = $t->price;
            $add->quantity = $item->quantity;

            $orders[] = $add;
            
        }
        // dd($order);

        return view('cashier.payment', compact('orders', 'offers', 'tax', 'servCharge', 'discounted'));
    }

    public function invoice(Request $request){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $order = $request->input('orders');        
        $offers = $request->input('offers'); 
        $tax = floatval($request->input('tax'));
        $servCharge = floatval($request->input('servCharge'));  
        $discounted = floatval($request->input('discounted'));     
        
        // dd($discounted);

        $order = json_decode($order);
        $offers = json_decode($offers);         
                

        $originalTotal = 0;        

        //totalBill
        $total = $originalTotal+($tax*($originalTotal/100))-$discounted+$servCharge;

        //making the order
        $currentTime = now()->format('H:i:s');
        $currentDate = $currentDate = now()->toDateString();
        
        
        $neworder = CustomerOrder::create([
            'orderType' => 'dinein',
            'orderDate' => $currentDate,
            'orderTime' => $currentTime,
            'orderStatus' => 'Placed',
            'OfferID' => $offers == null ? null : $offers[0]->id
        ]);    
        
        //adding items to database
        foreach ($order as $o){
            $originalTotal += (($o->itemPrice+$o->toppingPrice)*$o->quantity);    
            
            //customerorder_menuitem
            $cusmenu = CustomerOrder_MenuItem::create([
                'orderID' => $neworder->orderID,
                'menuID' => $o->itemID,
                'quantity' => $o->quantity
            ]);            

            //custoemrorder_extratopping

            $custop = CustomerOrder_ExtraTopping::create([
                'orderID' => $neworder->orderID,
                'toppingID' => $o->toppingID,
                'menuID' => $o->itemID
            ]);
        }        


        //making the invoice
        $invoice = CustomerInvoice::create([
            'tax' => $tax,
            'discountAmount' => $discounted,
            'serviceCharge' => $servCharge,
            'amount' => $originalTotal,
            'totalBill' => $total,
            'OfferID' => $offers == null ? null : $offers[0]->id,
            'orderID' => $neworder->orderID
        ]);

        return view('cashier.invoice', compact('order', 'offers', 'tax', 'servCharge', 'discounted', 'total', 'neworder', 'invoice'));
    }

    public function history(Request $request){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $currentDate = now()->toDateString();
        
        $orders = CustomerOrder::with('customerInvoice')->where('orderDate', $currentDate)->get(); 
        
        // dd($orders);

        return view('cashier.order-history', compact('orders'));
    }

    
}
