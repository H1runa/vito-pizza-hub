@extends('layouts.manager')
@section('title', 'Customer Returns')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Customer Returns</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Order ID</th>                                                
                        <th class="text-center">Order Date</th>
                        <th class="text-center">Return Date</th>     
                        <th class="text-center">Items</th>                            
                        <th class="text-center">Reason</th>
                        <th class="text-center">Action Taken</th>
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($data as $d)
                        <tr>
                            <td class="text-center">{{$d['order']->orderID}}</td>
                            <td class="text-center">{{$d['order']->orderDate}}</td>
                            <td class="text-center">{{$d['return']->orderReturn_Date}}</td>
                            <td class="text-center"><select>
                                <option class="text-center" selected>View Items</option>
                                @foreach ($d['menuItems'] as $item)                                    
                                    <option class="text-center" disabled>{{$item->itemName}}</option>
                                @endforeach
                            </select></td>                
                            <td class="text-center">{{$d['return']->reason}}</td>
                            <td class="text-center">{{$d['return']->actionTaken}}</td>
                            <td class="text-center">
                                <button class="bg-transparent border-0 delete-btn" data-id="{{$d['return']->cusRetID}}">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('manager.deletereturn', $d['return']->cusRetID)}}" method="POST">
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
                    title: "Add Order Return",
                    html: `
                        <form id="returnForm" action='{{route('manager.addreturn')}}' method='POST'>
                            @csrf
                            <div class="mb-3">
                                <label for="orderID" class="form-label">Order ID</label>
                                <input type="number" name="orderID" id="orderID" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="returnDate" class="form-label">Return Date</label>
                                <input type="date" name="returnDate" id="returnDate" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="actionTaken" class="form-label">Action Taken</label>
                                <textarea name="actionTaken" id="actionTaken" class="form-control" rows="3" required></textarea>
                            </div>

                            <button id='addItemSubmit' hidden type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
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
    {{-- Delete button --}}
    <script>
        $(document).ready(function(){
            $('.delete-btn').on('click', function(){
                let id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    
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