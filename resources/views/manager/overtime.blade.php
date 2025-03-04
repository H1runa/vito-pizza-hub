@extends('layouts.manager')
@section('title', 'Overtime Allowance')

@section('content')
    <div class="container mt-4">        
        <h2 class="mb-3 text-center">Staff Overtime</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Staff Name</th>   
                        <th class="text-center">Date</th>
                        <th class="text-center">Amount</th> 
                        <th class="text-center">Hours</th>                       
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                </thead>
                <tbody class="text-center">
                    @foreach ($data as $d)
                        <tr>
                            <td class="text-center">{{$d['staff']->firstName.' '.$d['staff']->lastName}}</td>
                            <td class="text-center">{{$d['ot']->date}}</td>
                            <td class="text-center">{{$d['ot']->amount}}</td>                                    
                            <td class="text-center">{{$d['ot']->hour}}</td> 
                            <td>           
                                <button class="bg-transparent border-0 delete-btn" >
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>                                                     
                                <form id="deleteForm" action="{{route('overtime.delete', $d['ot']->OTID)}}" method="POST">
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
                    title: "Add overtime",
                    html: `
                        <div class='card p-4''>                            
                            <form id="dataForm" method='POST' action="{{route('overtime.store')}}">
                                @csrf
                                <!-- Date -->                                
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>

                                <!-- Hour -->
                                <div class="mb-3">
                                    <label for="hour" class="form-label">Hour</label>
                                    <input type="number" class="form-control" id="hour" name="hour" min="0" required>
                                </div>

                                <!-- Amount -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                                </div>

                                <!-- Staff ID -->
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input type="text" class="form-control" id="staffID" name="staffID" required>
                                </div>

                                <!-- Submit Button -->
                                <button hidden id='addItemSubmit' type="submit" class="btn btn-primary w-100">Submit</button>
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