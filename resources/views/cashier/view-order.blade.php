@extends('layouts.cashier')
@section('title', 'Cashier Order')

@section('content')    
    <div class="container mt-4">
        <h1 class="mb-4">Order</h1>
        
        @foreach ($data as $item)  
        <div class="order-item card mb-3 p-3 shadow-sm">
            <div class="row align-items-center">
                {{-- Hiding values --}}
                <input type="number" hidden id="itemID" value="{{$item['index']}}">
                <input type="number" hidden id="menuID" value="{{$item['menuID']}}">
                <!-- Item Name -->
                <div class="col-md-3">
                    <h5 class="mb-0">Item: <strong>{{ $item['itemName'] }}</strong></h5>
                </div>

                <!-- Quantity Input -->
                <div class="col-md-2">
                    <label for="quantity_{{ $loop->index }}" class="form-label">Quantity</label>
                    <input id="quantity_{{ $loop->index }}" type="number" class="form-control quantity" value="{{ $item['quantity'] }}">
                </div>

                <!-- Price Input (Read-Only) -->
                <div class="col-md-2">
                    <label for="price_{{ $loop->index }}" class="form-label">Price (Rs.)</label>
                    <input id="price_{{ $loop->index }}" type="text" class="form-control price" value="{{ $item['price'] }}" readonly>
                </div>

                <!-- Topping Select -->
                <div class="col-md-3">
                    <label for="toppingSelect_{{ $loop->index }}" class="form-label">Topping</label>
                    <select data-price='{{$item['toppingPrice']}}' name="toppingSelect" id="toppingSelect_{{ $loop->index }}" class="form-select toppingSelect">
                        @foreach ($toppings as $t)
                            <option data-price='{{$t->price}}' value="{{ $t->toppingID }}" {{ $t->toppingID == $item['topping'] ? 'selected' : '' }}>
                                {{ $t->toppingName }}                                
                            </option>                                                                    
                        @endforeach                        
                    </select>
                </div>
                {{-- Delete button --}}
                <div class="col-md-2">
                    <button data-id='{{$item['index']}}' class="bg-transparent border-0 deleteItemBtn">
                        <i class="bi bi-x-square-fill display-5 text-danger"></i>
                    </button>                    
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- Total Price & Checkout -->
        <div class="card p-3 shadow-sm mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Total Price: <strong>Rs. <span id="totalPrice">0.00</span></strong></h4>
                <small id="discountContainer" class="mx-2 text-muted">Offer: Rs. <span id="discountAmount">0.00</span></small>
                <small style="display: none" id="manualDiscountContainer" class="mx-2 text-muted">Discount: Rs. <span id="manualDiscountAmount">0.00</span></small>
                <button id="checkoutBtn" class="btn btn-success btn-lg">Checkout</button>
            </div>
        </div>

        <!-- Discount Section -->
        <div class="card p-3 shadow-sm mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="w-50">
                    <label for="discountInput" class="form-label mb-0">Discount (%)</label>
                    <input type="number" id="discountInput" class="form-control" placeholder="Enter discount percentage" min="0" max="100">
                </div>
                <button id="applyDiscountBtn" class="btn btn-primary btn-lg">Apply Discount</button>
            </div>
        </div>

        <!-- Save/Delete Order Button -->
        <div class="text-center">
            <button id="saveOrder" class="btn btn-primary btn-lg">Save Order</button>
            <button id="deleteOrder" class="btn btn-danger btn-lg">Delete Order</button>
        </div>
        {{-- Order form for passing data --}}
        <form action="{{route('cashier.checkout')}}" method="POST" id="orderForm">
            @csrf
            <input type="hidden" id="orderInput" name="orders">
            <input type="hidden" id="offersInput" name="offers">
            <input type="hidden" id="taxInput" name="tax">
            <input type="hidden" id="servCharge" name="servCharge">
            <input type="hidden" id="discounted" name="discounted">
            <button hidden type="submit" id="submitBtn">Button</button>            
        </form>
    </div>         
    
@endsection



@push('scripts')
    {{-- On page load --}}
    <script>
        $(document).ready(function(){
            window.discounted = 0;
        })
    </script>
    {{-- Update order button --}}
    <script>
        $(document).ready(function(){
            $('#saveOrder').on('click', function(){
                let order = [];
                $('.order-item').each(function(){
                    let itemID = $(this).find('#itemID').val();
                    let menuID = $(this).find('#menuID').val();
                    let quantity = $(this).find('.quantity').val();
                    let price = $(this).find('.price').val();
                    let topping = $(this).find('.toppingSelect').val();

                    order.push({
                        quantity: quantity,
                        id: menuID,
                        top: topping,                                            
                    });
                })

                localStorage.setItem('order', JSON.stringify(order));
                calcTotal(); //updating the total
            });
        });        
    </script>
    {{-- Delete order item --}}
    <script>
        $(document).ready(function(){
            $('.deleteItemBtn').on('click', function(){            
                let id = $(this).data('id');

                let order = [];
                $('.order-item').each(function(){                                        
                    let itemID = $(this).find('#itemID').val();  
                    let menuID = $(this).find('#menuID').val();                  
                    if(itemID == id){                                                
                        $(this).remove();
                        return;
                    }

                    
                    let quantity = $(this).find('.quantity').val();
                    let price = $(this).find('.price').val();
                    let topping = $(this).find('.toppingSelect').val();

                    order.push({
                        quantity: quantity,
                        id: menuID,
                        top: topping,                                            
                    });
                })

                localStorage.setItem('order', JSON.stringify(order));
                calcTotal(); //updating the total

            })
        })
    </script>
    {{-- Function to calculate total --}}
    <script>
        function calcTotal(){
            let total = 0.00;
            let ogTotal = 0.00;
            let offer = JSON.parse(localStorage.getItem('offers'));
            let discount = 0;                        

            if (offer != null){
                if(!(Object.keys(offer).length === 0)){                
                    discount = parseFloat(offer[0].rate);     
                            
                }
            }
            

            $('.order-item').each(function(){
                let price = parseFloat($(this).find('.price').val());                
                let quantity = parseFloat($(this).find('.quantity').val());                                               
                let selectedTopping = $(this).find('.toppingSelect').find('option:selected');
                let topPrice = parseFloat(selectedTopping.data('price'));
                let itemTotal = 0;
                
                itemTotal = (price+topPrice)*quantity;
                // total += itemTotal;
                let save = 0;
                save = ((itemTotal/100)*discount);   
                // window.discounted = save; 
                // alert(save);            
                total += itemTotal - save; 
                ogTotal += itemTotal;
                $('#discountAmount').text(save.toFixed(2));
                // alert(total);
            })

            // alert(total-ogTotal);
            window.discounted = ogTotal-total;
            $('#discountAmount').text((ogTotal-total).toFixed(2));
            
            $('#totalPrice').text(total.toFixed(2));
        }

        $(document).ready(function(){
            calcTotal();
        })
    </script>
    {{-- calculating the discounted price to calc the discount/offer --}}
    <script>
        $(document).ready(function(){
            let offers = JSON.parse(localStorage.getItem('offers'));
            let discount = 0;            
            let total = parseFloat($('#totalPrice').text());
            let orignalTotal = total;

            if (!offers){
                return;
            }

            offers.forEach((offer, index) => {                
                total = total * (1 - (parseFloat(offer.rate)/100));
            });

            if (total == orignalTotal){
                $('#totalPrice').text(total.toFixed(2));
                $('#discountContainer').hide();
            } else {
                let saved = (orignalTotal-total);

                if(!window.discounted || window.discounted == 0){
                    window.discounted = 0;
                }
                window.discounted += saved
                $('#totalPrice').text(total.toFixed(2));
                $('#discountAmount').text(saved.toFixed(2));
            }
            calcTotal();
            
        })
    </script>
    {{-- Apply discount --}}
    <script>
        $(document).ready(function(){
            $('#applyDiscountBtn').on('click', function(){
                let discount = parseFloat($('#discountInput').val());
                let total = parseFloat($('#totalPrice').text());
                let originalTotal = total;
                // alert(discount);

                if(discount>0){                    
                    total = total * (1-(discount/100));
                    let saved = originalTotal-total;

                    if(!window.discounted || window.discounted == 0){
                        window.discounted = 0;
                    }
                    window.discounted += saved; //saving to calculate the total discount
                    
                    $('#totalPrice').text(total.toFixed(2));
                    $('#manualDiscountContainer').show();
                    $('#manualDiscountAmount').text(saved.toFixed(2));

                    $(this).prop('disabled', true);

                }

            })
        })
    </script>
    {{-- Delete order --}}
    <script>
        $(document).ready(function(){
            $('#deleteOrder').on('click', function(){
                localStorage.removeItem('order');
                localStorage.removeItem('offers');

                window.location.href = '{{route('cashier.order')}}'
            })
        })
    </script>
    {{-- Checkout button --}}
    <script>        
        $(document).ready(function(){
            $('#checkoutBtn').on('click', function(event){                
                event.preventDefault();                 
                let order = localStorage.getItem('order');
                let offers = localStorage.getItem('offers');
                
                if(!order){                    
                    order = [];                                     
                }
                if(!offers){
                    offers = [];
                }
                
                $('#orderInput').val(order);
                $('#offersInput').val(offers);
                // alert(window.discounted);
                $('#discounted').val(window.discounted);
                // alert(window.discounted);

                // $('#submitBtn').click();

                Swal.fire({
                    title: "Proceed to Payment?",
                    html: `
                        <div class="card shadow-sm p-4">
                            
                            <form>
                                <!-- Tax Field -->
                                <div class="mb-3">
                                    <label for="tax" class="form-label">Tax (%)</label>
                                    <input value = '0'  type="number" id="tax" class="form-control" placeholder="Enter tax percentage" min="0" required>
                                </div>

                                <!-- Service Charge Field -->
                                <div class="mb-3">
                                    <label for="serviceCharge" class="form-label">Service Charge (Rs.)</label>
                                    <input  value='0' type="number" id="serviceCharge" class="form-control" placeholder="Enter service charge" min="0" required>
                                </div>

                                
                            </form>
                        </div>                    
                    ` ,
                    showCancelButton: true,
                    showConfirmButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        let modal = Swal.getPopup();
                        let tax = parseFloat(modal.querySelector('#tax').value);
                        let servCharge = parseFloat(modal.querySelector('#serviceCharge').value);
                        
                        if(tax< 0 || tax>100){
                            Swal.showValidationMessage('Enter a valid tax percentage');
                            return false;
                        }
                        if (servCharge<0){
                            Swal.showValidationMessage('Enter a valid service charge amount');
                            return false;
                        }

                        $('#taxInput').val(tax);
                        $('#servCharge').val(servCharge);

                        $('#submitBtn').click();                        
                    }
                })
            })
        })
    </script>
@endpush