@extends('layouts.manager')
@section('title', 'Service Charge Allowance')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Service Charge Allowance</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">ID</th>   
                        <th class="text-center">Date</th>
                        <th class="text-center">Amount</th>                        
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                </thead>
                <tbody class="text-center">
                    @foreach ($servs as $s)
                        <tr>
                            <td class="text-center">{{$s->servChargeID}}</td>
                            <td class="text-center">{{$s->date}}</td>
                            <td class="text-center">{{$s->amount}}</td>                                    
                            <td>                                
                                <button class="bg-transparent border-0 delete-btn" >
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('serv.delete', $s->servChargeID)}}" method="POST">
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
                    title: "Add Service Charge Allowance",
                    html: `
                        <div class='card p-4''>                            
                            <form id="dateAmountForm" action="{{route('serv.store')}}" method='POST'>
                                @csrf
                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>

                                <!-- Amount -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                </div>

                                <!-- Submit Button -->
                                <button id='addItemSubmit' hidden type="submit" class="btn btn-primary w-100">Submit</button>
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