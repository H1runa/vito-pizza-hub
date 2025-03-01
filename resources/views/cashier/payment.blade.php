@extends('layouts.cashier')
@section('title', 'Payment')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Title for the invoice form -->
                <h3 class="mb-4 text-center">Invoice Payment</h3>

                <!-- Payment buttons form -->
                <form method="POST" action="{{ route('cashier.invoice') }}">
                    @csrf
                    
                    <!-- Hidden inputs for the data -->
                    <input name="orders" type="hidden" value="{{ json_encode($orders) }}">
                    <input name="offers" type="hidden" value="{{ json_encode($offers) }}">
                    <input name="tax" type="hidden" value="{{ $tax }}">
                    <input name="servCharge" type="hidden" value="{{ $servCharge }}">
                    <input name="discounted" type="hidden" value="{{ $discounted }}">

                    <!-- Stacked Payment Buttons -->
                    <div class="d-flex flex-column">
                        <button type="submit" name="payment_method" value="cash" class="btn btn-success btn-block btn-lg mb-3">Cash</button>
                        <button type="submit" name="payment_method" value="card" class="btn btn-primary btn-block btn-lg">Card</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    
@endpush