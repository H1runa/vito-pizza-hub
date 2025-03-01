@extends('layouts.cashier')
@section('title', 'Order History')

@section('content')
    <div class="container">

        <h3 class="mb-4 text-center mt-3">Order History</h3>

        
        <table class="table table-bordered table-striped datatable" id="ordersTable">
            <thead>  
                <tr>
                    <th class="text-center">ID/Token</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Time</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Price (Rs.)</th>
                </tr>
            </thead>
            <tbody>  
                @foreach ($orders as $order)
                    <tr>
                        <td class='text-center'>{{ $order->orderID }}</td>
                        <td class='text-center'>{{ ucfirst(strtolower($order->orderType)) }}</td>
                        <td class='text-center'>{{ $order->orderDate }}</td>
                        <td class='text-center'>{{ $order->orderTime }}</td>
                        <td class='text-center'>{{ $order->orderStatus }}</td>
                        <td class='text-center'>{{ $order->customerInvoice->totalBill }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


@push('scripts')
    
@endpush