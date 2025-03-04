@extends('layouts.manager')
@section('title', 'Sales by Menu Item (Monthly)')

@section('content')
    <h2 class="mb-3 text-center">Trending Items (Month)</h2>
    <div class="chart-container">
        <canvas id="menuItemChart"></canvas>
    </div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('menuItemChart');

    new Chart(ctx, {
        type: 'bar', // You can change the chart type to 'line', 'pie', etc.
        data: {
            labels: {!! json_encode($labels) !!}, // Menu item names
            datasets: [{
                label: 'Menu Item Sales (Monthly)',
                data: {!! json_encode($sales) !!}, // Sales data for the month
                backgroundColor: 'rgba(230,58,15,0.8)', // Color of the bars
                borderColor: 'rgba(54, 162, 235, 1)', // Border color of the bars
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true, // Y-axis starts from 0
                    min: 0, // Ensure it starts at 0
                },
                x: {
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10, // Prevent overcrowding the x-axis labels
                    }
                }
            }
        }
    });
</script>
@endpush
