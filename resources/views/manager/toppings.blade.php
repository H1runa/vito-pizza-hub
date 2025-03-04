@extends('layouts.manager')
@section('title', 'Manage Toppings')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Extra Toppings</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Topping Name</th>                                                
                        <th class="text-center">Price</th>
                        <th class="text-center">Availability</th>     
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($toppings as $t)
                        <tr>
                            <td>{{ $t->toppingName }}</td>                                                        
                            <td>Rs. {{ number_format($t->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $t->availablity == 'True' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $t->availablity == 'True' ? 'Available' : 'Not Available' }}
                                </span>
                            </td>                           
                            <td>
                                <button class="bg-transparent border-0 edit-btn" data-id="{{$t->toppingID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn" data-id="{{$t->toppingID}}">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('topping.delete', $t->toppingID)}}" method="POST">
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
                    title: "Add Topping",
                    html: `
                        <div class='card p-4'>
                            <form id="toppingForm" action="{{route('topping.create')}}" method="POST">
                                @csrf                                
                                <div class="mb-3">
                                    <label for="toppingName" class="form-label">Topping Name</label>
                                    <input type="text" id="toppingName" name="toppingName" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                                </div>

                                <div class="mb-3">
                                    <label for="availability" class="form-label">Availability</label>
                                    <select id="availability" name="availability" class="form-select" required>
                                        <option value="True">Available</option>
                                        <option value="False">Unavailable</option>
                                    </select>
                                </div>

                                <button id="addItemSubmit" hidden type="submit" class="btn btn-primary w-100">Submit</button>
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
                fetch(`/api/topping/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.topping){
                        Swal.fire({
                            title: "Edit Item",
                            html: `
                                <div class='card p-4'>
                                    <form id="editItemForm" action="" method="POST">
                                        @csrf       
                                        @method('PUT')                         
                                        <div class="mb-3">
                                            <label for="toppingName" class="form-label">Topping Name</label>
                                            <input value='${data.topping.toppingName}' type="text" id="toppingName" name="toppingName" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input value='${data.topping.price}' type="number" id="price" name="price" class="form-control" step="0.01" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="availability" class="form-label">Availability</label>
                                            <select id="availability" name="availability" class="form-select" required>
                                                <option ${data.topping.availablity == 'True' ? 'selected' : ''} value="True">Available</option>
                                                <option ${data.topping.availablity == 'False' ? 'selected' : ''} value="False">Unavailable</option>
                                            </select>
                                        </div>

                                        <button id="updateItemSubmit" hidden type="submit" class="btn btn-primary w-100">Submit</button>
                                    </form>
                                <div>
                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.topping.toppingID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/topping/${updateID}/update`);
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