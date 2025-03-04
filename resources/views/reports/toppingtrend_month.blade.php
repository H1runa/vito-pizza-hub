@extends('layouts.manager')
@section('title', 'Topping Popularity - Monthly')

@section('content')
    <h2 class="mb-3 text-center">Trending Toppings (Month)</h2>
    <div class="chart-container">
        <canvas id="toppingChart"></canvas>
    </div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('toppingChart');

    new Chart(ctx, {
        type: 'bar', // You can change this to line, pie, etc.
        data: {
            labels: {!! json_encode($toppingNames) !!}, // Topping names for the x-axis
            datasets: [{
                label: 'Total Sales (Monthly)',
                data: {!! json_encode($sales) !!}, // Total sales for each topping
                backgroundColor: 'rgba(230,58,15,0.8)', // Color of the bars
                borderColor: 'rgba(255, 99, 132, 1)', // Border color of the bars
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true, // Y-axis starts from 0
                    min: 0,
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
