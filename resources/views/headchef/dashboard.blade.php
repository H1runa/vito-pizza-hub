@extends('layouts.app')

@section('title', 'HeadChef Dashboard')

@section('content')

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
        <a class="navbar-brand fs-3" href="#" style="font-family: 'Permanent Marker', sans-serif; color: #e63a0f;">Vito Wood Fired Pizza</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            {{-- navbar content goes here --}}
        </ul>
        

        <ul class="dropdown">
            <a class="nav-link dropdown-toggle mt-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-2 text-secondary"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-sm-end">                   
                <button class="dropdown-item edit-profile-btn" data-id="{{session('system_user_id')}}">Edit Profile</button>                        
                <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>                
            </ul>
            </ul>            
        </div>
    </nav>

    <div class="container mx-auto m-5">
        <ul class="nav nav-pills" id="contentTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dinein-tab" data-bs-toggle='tab' data-bs-target="#dinein" type="button">
                    Dine-In Orders
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pickup-tab" data-bs-toggle='tab' data-bs-target="#pickup" type="button">
                    Pickup Orders
                </button>
            </li>         
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="delivery-tab" data-bs-toggle='tab' data-bs-target="#delivery" type="button">
                    Delivery Orders
                </button>
            </li>         
        </ul>
        <div class="tab-content" id="tabContent">
            <div class="tab-pane fade show active" id="dinein" role="tabpanel">
                <div id="dinein-list" class="mt-3">                    
                    {{-- dinein orders --}}
                    <table border="1" class="datatable table table-bordered">
                        <thead>
                            <tr>                                
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $o)   
                                @if ($o->orderStatus == 'Finished' || $o->orderType != 'dinein')
                                    @continue
                                @endif   
                                <tr>
                                    <td>{{$o->customer->firstName.' '.$o->customer->lastName}}</td>
                                    <td>{{$o->menuItems->count()}}</td>
                                    <td>{{$o->orderDate}}</td>
                                    <td>
                                        {{$o->orderStatus}}
                                        <button data-id="{{$o->orderID}}" class="bg-transparent border-0 m-0 orderStatusEditBtn">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>                                                                                
                                    </td>
                                                              
                                </tr>                      
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade " id="pickup" role="tabpanel">
                <div id="pickup-list" class="mt-3">
                    {{-- pickup orders --}}
                    <table border="1" class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                                                                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $o)   
                                @if ($o->orderStatus == 'Finished' || $o->orderType != 'pickup')
                                    @continue
                                @endif   
                                <tr>
                                    <td>{{$o->customer->firstName.' '.$o->customer->lastName}}</td>
                                    <td>{{$o->menuItems->count()}}</td>
                                    <td>{{$o->orderDate}}</td>
                                    <td>
                                        {{$o->orderStatus}}
                                        <button data-id="{{$o->orderID}}" class="bg-transparent border-0 m-0 orderStatusEditBtn">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>                                                                                
                                    </td>
                                                               
                                </tr>                      
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>   
            <div class="tab-pane fade " id="delivery" role="tabpanel">
                <div id="delivery-list" class="mt-3">
                    {{-- delivery orders --}}
                    <table border="1" class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Items</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                                                                             
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $o)   
                                @if ($o->orderStatus == 'Finished' || $o->orderType != 'delivery')
                                    @continue
                                @endif   
                                <tr>
                                    <td>{{$o->customer->firstName.' '.$o->customer->lastName}}</td>
                                    <td>{{$o->menuItems->count()}}</td>
                                    <td>{{$o->orderDate}}</td>
                                    <td>
                                        {{$o->orderStatus}}
                                        <button data-id="{{$o->orderID}}" class="bg-transparent border-0 m-0 orderStatusEditBtn">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>                                                                                
                                    </td>
                                                              
                                </tr>                      
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>   
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('.orderStatusEditBtn').on('click', function(){
                let orderID = $(this).data('id');
                let url = '/order/'+orderID+'/status/edit';
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'Application/json'
                    }
                })
                .then(response=>{
                    if(!response.ok){
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data=>{
                    Swal.fire({
                        title: 'Edit Order Status',
                        html: data.html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: ()=>{                            
                            $('#editOrderStatusForm').submit();
                        },
                    })
                })
            })
        })
    </script>
@endpush