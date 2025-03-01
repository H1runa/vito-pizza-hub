@extends('layouts.cashier')
@section('title', 'Offers')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Available Offers</h1>

        <div class="row">
            @foreach ($offers as $offer)                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="offer-item d-flex flex-column h-100 p-3 border rounded bg-light shadow-sm">
                        <h3 id="offerName" class="fw-bold">{{ $offer->offerName }}</h3>
                        <h5 id="rateContainer" class="text-success">Rate: <span id="offerRate">{{ number_format($offer->offerRate, 2) }}</span>%</h5>                        
                        <!-- Scrollable description -->
                        <div class="text-muted flex-grow-1 overflow-auto"
                            style="max-height: 4.5rem; overflow-y: auto; overflow-x: hidden; line-height: 1.5rem; word-wrap: break-word; white-space: normal;">
                            {{ $offer->description }}
                        </div>

                        <input type="hidden" id="offerIDHidden" value="{{$offer->OfferID}}">
                        <button class="btn btn-primary w-100 mt-4 offerBtn">Add to Order</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


@push('scripts')
    {{-- Detecting already picked offer --}}
    <script>
        $(document).ready(function(){
            let offers = JSON.parse(localStorage.getItem('offers'));
            $('.offerBtn').each(function(){
                let offername = $(this).siblings('#offerName').text();
                // alert(offername);
                if(offers && offers.some(offer => offer.name == offername)){
                    
                    $(this).text('Remove'); $(this).removeClass('btn-primary'); $(this).addClass('btn-danger');
                }
            })
        })
    </script>
    {{-- Offer button functionality --}}
    <script>
        $(document).ready(function(){
            $('.offerBtn').on('click', function(){
                if ($(this).text() == 'Add to Order'){
                    let offerName = $(this).siblings('#offerName').text();
                    let offerRate = $(this).siblings('#rateContainer').find('#offerRate').text();      
                    let offerID = $(this).siblings('#offerIDHidden').val();      

                    let offers = [];
                    if (JSON.parse(localStorage.getItem('offers'))){
                        offers.push({id:offerID, name:offerName, rate:offerRate});
                        localStorage.setItem('offers',JSON.stringify(offers));
                    } else {
                        offers = [];
                        offers.push({id:offerID, name:offerName, rate:offerRate});
                        localStorage.setItem('offers', JSON.stringify(offers));
                    }                                        
                    $(this).text('Remove'); $(this).removeClass('btn-primary'); $(this).addClass('btn-danger');
                    $('.offerBtn:contains("Add to Order")').prop('disabled', true); //disabling the other buttons

                } else if ($(this).text() == 'Remove'){
                    let offerName = $(this).siblings('#offerName').text();
                    let offerRate = $(this).siblings('#rateContainer').find('#offerRate').text();      

                    let offers = [];
                    offers = JSON.parse(localStorage.getItem('offers'));
                    offers = offers.filter(offer => offer.name != offerName);

                    localStorage.setItem('offers', JSON.stringify(offers));

                    $(this).text('Add to Order'); $(this).removeClass('btn-danger'); $(this).addClass('btn-primary');
                    $('.offerBtn').prop('disabled', false); //reenabling all the buttons
                }
                
            })
        })

    </script>    
@endpush