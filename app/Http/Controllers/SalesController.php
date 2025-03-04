<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\SalesChart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CustomerInvoice;



class SalesController extends Controller
{


    public function salesByDay()
    {
        
        $invoices = CustomerInvoice::all();
    
        
        $startDate = Carbon::now()->startOfWeek(); 
        $endDate = Carbon::now()->endOfWeek(); 
    
        
        $dates = [];
        $sales = [];
    
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dates[] = $formattedDate; 
    
            
            $salesForDay = $invoices->filter(function($invoice) use ($formattedDate) {
                
                return Carbon::parse($invoice->orderDate)->startOfDay()->format('Y-m-d') == $formattedDate;
            })->sum('totalBill'); 
    
            $sales[] = $salesForDay > 0 ? $salesForDay : 0; 
        }
    
        // dd($dates, $sales);
    
        return view('reports.sales_week', compact('dates', 'sales'));
    }
    

public function salesByMonth()
{

    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;


    $salesData = DB::table('customerinvoice')
        ->join('customerorder', 'customerinvoice.orderID', '=', 'customerorder.orderID')
        ->select(DB::raw('DAY(customerorder.orderDate) as day'), DB::raw('SUM(customerinvoice.totalBill) as totalSales'))
        ->whereMonth('customerorder.orderDate', $currentMonth)
        ->whereYear('customerorder.orderDate', $currentYear)
        ->groupBy(DB::raw('DAY(customerorder.orderDate)'))
        ->get();


    $allDays = range(1, 31);


    $dates = $allDays;
    $sales = [];

    foreach ($allDays as $day) {
        $sale = $salesData->firstWhere('day', $day);
        $sales[] = $sale ? $sale->totalSales : 0; 
    }

    return view('reports.sales_month', compact('dates', 'sales'));
}


public function salesByMenuItem()
{
    
    $startDate = Carbon::now()->startOfWeek();
    $endDate = Carbon::now()->endOfWeek();

    
    $menuItemSales = DB::table('customerorder_menuitem')
        ->join('customerorder', 'customerorder.orderID', '=', 'customerorder_menuitem.orderID')
        ->whereBetween('customerorder.orderDate', [$startDate, $endDate])
        ->groupBy('customerorder_menuitem.menuID')
        ->select('customerorder_menuitem.menuID', DB::raw('count(*) as totalSold'))
        ->get();

    
    $menuItems = DB::table('menuitem')
        ->whereIn('menuID', $menuItemSales->pluck('menuID')->toArray()) 
        ->get();

    
    $labels = $menuItems->pluck('itemName'); 
    $sales = $menuItemSales->pluck('totalSold');

    
    return view('reports.itemtrend_week', compact('labels', 'sales'));
}


public function salesByMenuItemMonth()
{
    
    $startDate = Carbon::now()->startOfMonth(); 
    $endDate = Carbon::now()->endOfMonth(); 

    
    $menuItemSales = DB::table('customerorder_menuitem')
        ->join('customerorder', 'customerorder.orderID', '=', 'customerorder_menuitem.orderID')
        ->whereBetween('customerorder.orderDate', [$startDate, $endDate])
        ->groupBy('customerorder_menuitem.menuID')
        ->select('customerorder_menuitem.menuID', DB::raw('count(*) as totalSold'))
        ->get();

    
    $menuItems = DB::table('menuitem')
        ->whereIn('menuID', $menuItemSales->pluck('menuID')->toArray()) 
        ->get();

    
    $labels = $menuItems->pluck('itemName'); 
    $sales = $menuItemSales->pluck('totalSold');

    
    return view('reports.itemtrend_month', compact('labels', 'sales'));
}


public function salesByToppingWeek()
{
    // Define the start and end date of the current week
    $startDate = Carbon::now()->startOfWeek(); // First day of the current week
    $endDate = Carbon::now()->endOfWeek(); // Last day of the current week

    // Query to count the popularity of toppings sold in the week
    $toppingSales = DB::table('customerorder_extratopping')
    ->join('customerorder', 'customerorder.orderID', '=', 'customerorder_extratopping.orderID')
    ->join('extratopping', 'extratopping.toppingID', '=', 'customerorder_extratopping.toppingID')
    ->whereBetween('customerorder.orderDate', [$startDate, $endDate])
    ->groupBy('customerorder_extratopping.toppingID', 'extratopping.toppingName') // Include toppingName here
    ->select('customerorder_extratopping.toppingID', 'extratopping.toppingName', DB::raw('count(*) as totalSold'))
    ->get();


    // Prepare the data for the chart
    $labels = $toppingSales->pluck('toppingName'); // Topping names for the x-axis
    $sales = $toppingSales->pluck('totalSold'); // Total sales for each topping

    // Return data to the view
    return view('reports.toppingtrend_week', compact('labels', 'sales'));
}

public function salesByToppingMonth()
{
    
    $startDate = Carbon::now()->startOfMonth(); 
    $endDate = Carbon::now()->endOfMonth(); 

    
    $toppingSales = DB::table('customerorder_extratopping')
        ->join('customerorder', 'customerorder.orderID', '=', 'customerorder_extratopping.orderID')
        ->join('extratopping', 'extratopping.toppingID', '=', 'customerorder_extratopping.toppingID')
        ->whereBetween('customerorder.orderDate', [$startDate, $endDate])
        ->groupBy('customerorder_extratopping.toppingID', 'extratopping.toppingName') 
        ->select('customerorder_extratopping.toppingID', 'extratopping.toppingName', DB::raw('count(*) as totalSold'))
        ->get();

    // dd($toppingSales);

   
    $toppingNames = $toppingSales->pluck('toppingName');
    $sales = $toppingSales->pluck('totalSold');

    return view('reports.toppingtrend_month', compact('toppingNames', 'sales'));
}






    



}

