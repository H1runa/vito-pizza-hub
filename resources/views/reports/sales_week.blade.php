@extends('layouts.manager')
@section('title', 'Sales Report')

@section('content')
    <h2 class="mb-3 text-center">Sales (Week)</h2>
    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>

@endsection


@push('scripts')
<script>
    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: {!! json_encode($dates) !!}, 
            datasets: [{
                label: 'Total Sales (Daily)',
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
