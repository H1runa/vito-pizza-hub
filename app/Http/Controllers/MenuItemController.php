<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function view(Request $request, $id){
        //validating if the user is logged in
        if(!session()->has('system_user_id')){
            return redirect()->route('auth.login');
        }

        $item = MenuItem::find($id);

        return response()->json([
            'html' => view('menuitem.view', compact('item'))->render(),
            'item_name' => $item->itemName
        ]);
    }
}
