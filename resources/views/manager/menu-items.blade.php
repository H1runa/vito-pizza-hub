@extends('layouts.manager')
@section('title', 'Menu Items')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Menu Items</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Item Name</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Availability</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($items as $i)
                        <tr>
                            <td>{{ $i->itemName }}</td>
                            <td>{{ $i->size }}</td>
                            <td>{{ $i->category }}</td>
                            <td>Rs. {{ number_format($i->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $i->availability ? 'bg-success' : 'bg-danger' }}">
                                    {{ $i->availability ? 'Available' : 'Not Available' }}
                                </span>
                            </td>
                            <td>
                                @if($i->image)
                                    <img src="{{ asset('storage/' . $i->image) }}" alt="Item Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <button class="bg-transparent border-0 edit-btn" data-id="{{$i->menuID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn" data-id="{{$i->menuID}}">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{ route('menuitem.delete', $i->menuID) }}" method="POST">
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
                    title: "Add Item",
                    html: `
                        <div class="container mt-4">                            
                            <div class="card p-4">
                                <form action="{{route('menuitem.create')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Menu Item Name -->
                                    <div class="mb-3">
                                        <label for="itemName" class="form-label">Menu Item Name</label>
                                        <input type="text" name="itemName" id="itemName" class="form-control" required>
                                    </div>

                                    <!-- Size Selection -->
                                    <div class="mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <select name="size" id="size" class="form-select" required>
                                            <option value="Small">Small</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Large">Large</option>
                                        </select>
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <input type="text" name="category" id="category" class="form-control" required>
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price (Rs.)</label>
                                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                                    </div>

                                    <!-- Availability -->
                                    <div class="mb-3">
                                        <label for="availability" class="form-label">Availability</label>
                                        <select name="availability" id="availability" class="form-select" required>
                                            <option value="1">Available</option>
                                            <option value="0">Not Available</option>
                                        </select>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button id='addItemSubmit' hidden type="submit" class="btn btn-primary w-50">Add Menu Item</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                fetch(`/api/menuitem/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.item){
                        Swal.fire({
                            title: "Edit Item",
                            html: `
                                <div class="container mt-4">                            
                                    <div class="card p-4">
                                        <form id='editItemForm' action="" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <!-- Menu Item Name -->
                                            <div class="mb-3">
                                                <label for="itemName" class="form-label">Menu Item Name</label>
                                                <input value='${data.item.itemName}' type="text" name="itemName" id="itemName" class="form-control" required>
                                            </div>

                                            <!-- Size Selection -->
                                            <div class="mb-3">
                                                <label for="size" class="form-label">Size</label>
                                                <select name="size" id="size" class="form-select" required>
                                                    <option ${data.item.size =='Small' ? 'selected' : ''} value="Small">Small</option>
                                                    <option ${data.item.size =='Medium' ? 'selected' : ''} value="Medium">Medium</option>
                                                    <option ${data.item.size =='Large' ? 'selected' : ''} value="Large">Large</option>
                                                </select>
                                            </div>

                                            <!-- Category -->
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <input value='${data.item.category}' type="text" name="category" id="category" class="form-control" required>
                                            </div>

                                            <!-- Price -->
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price (Rs.)</label>
                                                <input value='${data.item.price}' type="number" name="price" id="price" class="form-control" step="0.01" required>
                                            </div>

                                            <!-- Availability -->
                                            <div class="mb-3">
                                                <label for="availability" class="form-label">Availability</label>
                                                <select name="availability" id="availability" class="form-select" required>
                                                    <option ${data.item.availability == true ? 'selected' : ''} value="1">Available</option>
                                                    <option ${data.item.availability == false ? 'selected' : ''} value="0">Not Available</option>
                                                </select>
                                            </div>

                                            <!-- Image Upload -->
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Upload Image</label>
                                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="text-center">
                                                <button id='updateItemSubmit' hidden type="submit" class="btn btn-primary w-50">Add Menu Item</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.item.menuID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/menuitem/${updateID}/update`);
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