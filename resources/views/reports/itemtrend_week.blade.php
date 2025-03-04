@extends('layouts.manager')
@section('title', 'Sales by Menu Item')

@section('content')
    <h2 class="mb-3 text-center">Trending Items (Week)</h2>
    <div class="chart-container">
        <canvas id="menuItemChart"></canvas>
    </div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('menuItemChart');

    new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: {!! json_encode($labels) !!}, 
            datasets: [{
                label: 'Menu Item Sales (Weekly)',
                data: {!! json_encode($sales) !!}, 
                backgroundColor: 'rgba(230,58,15,0.8)', 
                borderColor: 'rgba(54, 162, 235, 1)', 
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true, 
                    min: 0, 
                },
                x: {
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 10, 
                    }
                }
            }
        }
    });
</script>
@endpush
