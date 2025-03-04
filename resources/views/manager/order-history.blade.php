@extends('layouts.manager')
@section('title', 'Order History')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Customer Order History</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle" style="table-layout: fixed;">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Customer Name</th>                                                
                        <th class="text-center">Username</th>
                        <th class="text-center">View History</th>                        
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($customers as $cus)
                        <tr>
                            <td>{{$cus->firstName.' '.$cus->lastName}}</td>
                            <td>{{$cus->username}}</td>
                            <td><a href="{{route('manager.order.history.view', $cus->cusID)}}" class="btn btn-primary">Select</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>   
@endsection



@push('scripts')
    
@endpush