<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function view(Request $request, $id){
        $item = MenuItem::find($id);

        return response()->json([
            'html' => view('menuitem.view', compact('item'))->render(),
            'item_name' => $item->itemName
        ]);
    }
}
