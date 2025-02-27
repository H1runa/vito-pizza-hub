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
                    <table class="datatable table table-hover table-sm table-bordered">
                        <thead class="table-secondary text-white">
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
                                <tr class="text-center align-middle">
                                    <td class="align-middle">{{$o->customer->firstName.' '.$o->customer->lastName}}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-info viewItemsBtn" data-id="{{$o->orderID}}">
                                            Items : {{$o->menuItems->count()}}
                                        </button>                                  
                                    </td>
                                    <td class="text-center align-middle">{{$o->orderDate}}</td>                                    
                                    <td class="align-middle">                                        
                                        <button data-id="{{$o->orderID}}" class="btn border-1 m-0 orderStatusEditBtn {{$o->orderStatus=='Preparing' ? 'btn-info' : 'btn-warning'}}">
                                            {{$o->orderStatus}}    
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
                    <table border="1" class="datatable table table-hover table-sm table-bordered">
                        <thead class="table-secondary text-white">
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
                                <tr class="text-center align-middle">
                                    <td>{{$o->customer->firstName.' '.$o->customer->lastName}}</td>
                                    <td>
                                        <button class="btn btn-info viewItemsBtn" data-id="{{$o->orderID}}">
                                            Items : {{$o->menuItems->count()}}
                                        </button> 
                                    </td>
                                    <td class="text-center">{{$o->orderDate}}</td>
                                    <td class="align-middle">                                        
                                        <button data-id="{{$o->orderID}}" class="btn border-1 m-0 orderStatusEditBtn {{$o->orderStatus=='Preparing' ? 'btn-info' : 'btn-warning'}}">
                                            {{$o->orderStatus}}    
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
                    <table border="1" class="datatable table table-hover table-sm table-bordered">
                        <thead class="table-secondary text-white">
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
                                <tr class="text-center align-middle">
                                    <td>{{$o->customer->firstName.' '.$o->customer->lastName}}</td>
                                    <td>
                                        <button class="btn btn-info viewItemsBtn" data-id="{{$o->orderID}}">
                                            Items : {{$o->menuItems->count()}}
                                        </button> 
                                    </td>
                                    <td class="text-center">{{$o->orderDate}}</td>
                                    <td class="align-middle">                                        
                                        <button data-id="{{$o->orderID}}" class="btn border-1 m-0 orderStatusEditBtn {{$o->orderStatus=='Preparing' ? 'btn-info' : 'btn-warning'}}">
                                            {{$o->orderStatus}}    
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
    {{-- Edit Profile Modal --}}
    <script>
        $(document).ready(function(){
            $('.edit-profile-btn').on('click', function(){
                let staffID = $(this).data('id');                
                let url = '/profile/'+staffID+'/edit';

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
                        title: 'Edit Profile',
                        html: data.html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: ()=>{                            
                            if ($('#editProfileForm')[0].checkValidity()){
                                $('#editProfileForm').submit();
                            } else {
                                Swal.showValidationMessage('Username must be filled out');
                                return false;
                            }
                        },
                        
                    })
                }).catch(error=>{
                    console.error('Edit profile error: ',error);
                })
            })
        })
    </script>
    {{-- Edit Button Script --}}
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
    {{-- View Item Script --}}
    <script>
        function viewMenuItem(){
            $(document).ready(function(){
                $('.viewItemBtn').on('click', function(){                    
                    let itemID = $(this).data('id');
                    let orderID = $(this).data('orderid');
                    let url = '/menuitem/'+itemID+'/view';

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
                            title: data.item_name,
                            html: data.html,
                            showCancelButton: true,                        
                            showConfirmButton: false,
                            focusConfirm: false,
                            preConfirm: ()=>{                            
                                //
                            },
                        }).then(()=>{
                            window.menuItemsModal(orderID);
                        })
                    })

                })
            })
        }
    </script>
    {{-- View Item List Script --}}
    <script>
        $(document).ready(function(){
            $('.viewItemsBtn').on('click', function(){
                let orderID = $(this).data('id');
                window.menuItemsModal = function(id){
                    let url = '/order/'+id+'/view';
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
                            title: 'Order Items',
                            html: data.html,
                            showCancelButton: true,                        
                            showConfirmButton: false,
                            focusConfirm: false,
                            preConfirm: ()=>{                            
                                //
                            },
                        })
                        viewMenuItem(); //adding the script for viewing menu item
                    })
                }
                window.menuItemsModal(orderID);

                

            })
        })
    </script>
    
@endpush