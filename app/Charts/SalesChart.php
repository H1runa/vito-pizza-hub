<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Support\Facades\DB;

class SalesChart extends Chart
{
    public function __construct()
    {
        parent::__construct();


        $salesData = DB::select("
            SELECT MONTH(co.orderDate) AS month, SUM(ci.totalBill) AS total
            FROM customerinvoice ci
            JOIN customerorder co ON ci.orderID = co.orderID
            GROUP BY MONTH(co.orderDate)
            ORDER BY month
        ");

        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        $labels = [];
        $values = [];

        foreach ($salesData as $sale) {
            $labels[] = $months[$sale->month - 1]; 
            $values[] = $sale->total;
        }

        $this->labels($labels);
        $this->dataset('Monthly Sales', 'bar', $values)
            ->backgroundColor('rgba(54, 162, 235, 0.5)');
    }

    
}

