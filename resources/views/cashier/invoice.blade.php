@extends('layouts.cashier')
@section('title', 'Invoice')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <h2 class="text-center mb-4">Invoice</h2>
        
        <!-- Invoice Details -->
        <div class="mb-3">
            <strong>Date:</strong> {{ $neworder->orderDate }}<br>
            <strong>Invoice ID:</strong> {{$invoice->cusInvoiceID}}  <br>
            <strong>Token :</strong> {{$neworder->orderID}}
        </div>

        <!-- Items Section -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Topping</th>
                        <th>Price (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($order as $o)
                            <td>{{$o->itemName}}</td>
                            <td>{{$o->quantity}}</td>
                            <td>{{$o->toppingName}}</td>
                            <td>Rs.{{$o->itemPrice}}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="d-flex justify-content-between mt-3">
            <h5>Subtotal:</h5>
            <h5>Rs. {{number_format($invoice->amount, 2)}}</h5>
        </div>
        <div class="d-flex justify-content-between">
            <h5>Discount:</h5>
            <h5>- Rs. {{number_format($invoice->discountAmount,2)}}</h5>
        </div>
        <div class="d-flex justify-content-between">
            <h5>Tax :</h5>
            <h5>+ {{$invoice->tax}}%</h5>
        </div>
        <div class="d-flex justify-content-between">
            <h5>Service Charge:</h5>
            <h5>+ Rs. {{number_format($invoice->serviceCharge,2)}}</h5>
        </div>
        <div class="d-flex justify-content-between border-top pt-2">
            <h4>Total:</h4>
            <h4>Rs. {{number_format($invoice->totalBill,2)}}</h4>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-4">
            <button class="btn btn-primary go-back">Print Invoice</button>
            <button class="btn btn-danger go-back">Close</button>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function(){
            $('.go-back').on('click', function(){
                localStorage.removeItem('order');
                localStorage.removeItem('offers');

                window.location.href = '{{route('cashier.dashboard')}}';
            });
        });
    </script>
@endpush