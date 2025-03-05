@extends('layouts.cashier')
@section('title', 'Cashier Dashboard')

@section('content')    
    <div id="accordion">
        @foreach ($categories as $category)
            <div class="card">
                <div class="card-header" id="heading{{$category->category}}">
                    <h5 class="mb-0">
                        <button class="btn btn-warning" data-bs-toggle="collapse" data-bs-target="#collapse{{$category->category}}">
                            {{$category->category}}
                        </button>
                    </h5>
                </div>
                <div id="collapse{{$category->category}}" class="collapse show" data-bs-parent="#accordion">
                    <div class="row">
                        @foreach ($items as $item)
                            {{-- Skipping the ones that dont belong to the relavent category --}}
                            @if ($item->category != $category->category)
                                @continue
                            @endif
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card shadow-sm">
                                    <h5 class="card-title text-center">{{$item->itemName}}</h5>
                                    <!-- Image with padding -->
                                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top p-3" alt="{{ $item->itemName }}" height='300' width="200">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Price -->
                                            <div class="col-6 d-flex justify-content-between">
                                                <strong>Price:</strong>
                                                <span>Rs.{{$item->price}}</span>
                                            </div>
                                            <!-- Category -->
                                            <div class="col-6 d-flex justify-content-between">
                                                <strong>Category:</strong>
                                                <span>{{$item->category}}</span>
                                            </div>
                                            <!-- Size -->
                                            <div class="col-6 d-flex justify-content-between">
                                                <strong>Size:</strong>
                                                <span>{{$item->size}}</span>
                                            </div>
                                            <!-- Availability -->
                                            {{-- <div class="col-6 d-flex justify-content-between">
                                                <strong>Name:</strong>
                                                <span>{{$item->itemName}}</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="card-footer text-center m-0 p-0">
                                        <button data-id='{{$item->menuID}}' class="addItemBtn btn btn-primary bg-transparent border-0 m-0 p-0">
                                            <i class="bi bi-plus-square-fill text-primary fs-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
        
    </div>



   
@endsection

@push('scripts')
    {{-- Script for adding items to order --}}
    <script>
        $(document).ready(function(){
            $('.addItemBtn').on('click', function(){
                let itemID = $(this).data('id');
                let url = '/cashier/'+itemID+'/additem';

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
                        title: data.item.itemName,
                        html: data.html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: ()=>{                            
                            // $('#quantitySelectionForm').submit();
                            let qty = $('#itemQuantity').val();
                            let topping = $('#topping').val();

                            //validation
                            if(!qty){
                                Swal.showValidationMessage('Quantity not selected');
                                return false;
                            }
                            
                            let itemID = data.item.menuID;

                            let array = [];

                            if (array = JSON.parse(localStorage.getItem('order'))){
                                // alert('Local Storage found');
                                array.push({quantity:qty, id:itemID, top:topping});
                                localStorage.setItem('order', JSON.stringify(array));
                            } else {
                                // alert(itemID);
                                // alert('Local Storage not found');
                                array = [];
                                array.push({quantity:qty, id:itemID, top:topping});
                                localStorage.setItem('order', JSON.stringify(array));
                            }
                        },
                        
                    })
                })
            })            
        })
    </script>
@endpush