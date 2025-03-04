<?php

namespace App\Http\Controllers;

use App\Models\CustomerOffer;
use Illuminate\Http\Request;

class CustomerOfferController extends Controller
{

    public function get($id){
        $offer = CustomerOffer::find($id);

        return response()->json([
            'offer' => $offer
        ]);
    }

    public function create(Request $request){
        try{
            $offer = CustomerOffer::create([
                'offerName' => $request->offerName,
                'offerRate' => $request->offerRate,
                'description' => $request->description
            ]);            
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Could not create offer');
        }

        return redirect()->back()->with('success', 'Offer created successfully');
    } 

    public function update(Request $request, $id){
        try{
            $offer = CustomerOffer::find($id);

            $offer->update([
                'offerName' => $request->offerName,
                'offerRate' => $request->offerRate,
                'description' => $request->description
            ]);
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Could not update');
        }

        return redirect()->back()->with('success', 'Offer updated');
    }

    public function delete($id){
        try {
            $offer = CustomerOffer::find($id);

            $offer->delete();
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Failed to delete');
        }

        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
