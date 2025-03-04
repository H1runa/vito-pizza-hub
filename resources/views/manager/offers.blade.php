@extends('layouts.manager')
@section('title', 'Customer offers')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Customer Offers</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle" style="table-layout: fixed;">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Offer Name</th>                                                
                        <th class="text-center">Rate</th>
                        <th class="text-center">Description</th>     
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($offers as $o)
                        <tr>
                            <td class='text-center'>{{ $o->offerName }}</td>                                                        
                            <td class='text-center'>{{$o->offerRate}}%</td>
                            <td class="text-wrap" style="max-width: 150px; max-height: 100px; overflow-y: auto;">{{$o->description}}</td>                                             
                            <td class='text-center'>
                                <button class="bg-transparent border-0 edit-btn" data-id="{{$o->OfferID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn" data-id="{{$o->OfferID}}">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('offer.delete', $o->OfferID)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" hidden class="btn btn-danger actualDeleteBtn">Delete</button>
                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@push('scripts')

    {{-- Add item button --}}
    <script>
        $(document).ready(function(){
            $('.addItemBtn').on('click', function(){
                Swal.fire({
                    title: "Add Offer",
                    html: `
                        <div class='card p-4'>
                            <form action="{{ route('offer.create') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="offerName" class="form-label">Offer Name</label>
                                    <input type="text" name="offerName" id="offerName" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="offerRate" class="form-label">Offer Rate (%)</label>
                                    <input type="number" name="offerRate" id="offerRate" class="form-control" min="0" max="100" step="0.1" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                                </div>

                                <button id='addItemSubmit' hidden type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        <div>

                    `,
                    showCancelButton: true,
                    focusConfirm: false,
                    preConfirm: () => {
                            $('#addItemSubmit').click();  
                            return false;         
                    }
                });
            })
        })
    </script>
    {{-- Edit item button --}}
    <script>
        $(document).ready(function(){
            $('.edit-btn').on('click', function(){
                let id = $(this).data('id');                
                fetch(`/api/offer/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.offer){
                        Swal.fire({
                            title: "Edit Item",
                            html: `
                                <div class='card p-4'>
                                    <form id='editItemForm' action="{{ route('offer.create') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="offerName" class="form-label">Offer Name</label>
                                            <input value='${data.offer.offerName}' type="text" name="offerName" id="offerName" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="offerRate" class="form-label">Offer Rate (%)</label>
                                            <input value='${data.offer.offerRate}' type="number" name="offerRate" id="offerRate" class="form-control" min="0" max="100" step="0.1" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" class="form-control" rows="3" required>${data.offer.description}</textarea>
                                        </div>

                                        <button id='updateItemSubmit' hidden type="submit" class="btn btn-primary">Submit</button>
                                    </form>

                                <div>
                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.offer.OfferID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/offer/${updateID}/update`);
                                    $('#updateItemSubmit').click();  
                                    return false;         
                            }
                        });
                    }
                })
            })
        })
    </script>
    {{-- Delete button --}}
    <script>
        $(document).ready(function(){
            $('.delete-btn').on('click', function(){
                let id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Any orders containing this item will also be deleted.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {                        
                        $(this).siblings('#deleteForm').children('.actualDeleteBtn').click();
                    }
                });
            })
        })
    </script>
    
@endpush