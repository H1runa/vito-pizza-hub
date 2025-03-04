@extends('layouts.manager')
@section('title', 'Topping Popularity (Weekly)')

@section('content')
    <h2 class="mb-3 text-center">Trending Toppings (Week)</h2>
    <div class="chart-container">
        <canvas id="toppingChart"></canvas>
    </div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('toppingChart');

    new Chart(ctx, {
        type: 'bar', 
        data: {
            labels: {!! json_encode($labels) !!}, 
            datasets: [{
                label: 'Topping Popularity (Weekly)',
                data: {!! json_encode($sales) !!}, 
                backgroundColor: 'rgba(230,58,15,0.8)', 
                borderColor: 'rgba(255, 99, 132, 1)', 
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
