@extends('layouts.manager')
@section('title', 'EPF Contribution')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Staff EPF</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Staff Name</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Rate</th>
                        <th class="text-center">Amount</th>                                      
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                </thead>
                <tbody class="text-center">
                    @foreach ($data as $d)
                        <tr>
                            <td class="text-center">{{$d['staff']->firstName.' '.$d['staff']->lastName}}</td>
                            <td class="text-center">{{$d['epf']->date}}</td>
                            <td class="text-center">{{$d['epf']->EPF_rate}}</td>
                            <td class="text-center">{{$d['epf']->amount}}</td>                      
                            <td>
                                <button class="bg-transparent border-0 edit-btn" data-id="{{$d['epf']->EPFID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn" >
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('epf.delete', $d['epf']->EPFID)}}" method="POST">
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
                    title: "Add EPF",
                    html: `
                        <div class='card p-4'>                            
                            <form id="epfForm" action="{{route('epf.store')}}" method="POST">
                                @csrf                                                             
                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>

                                <!-- EPF Rate -->
                                <div class="mb-3">
                                    <label for="EPF_rate" class="form-label">EPF Rate (%)</label>
                                    <input type="number" class="form-control" id="EPF_rate" name="EPF_rate" min="0" step="0.01" required>
                                </div>

                                <!-- Amount -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
                                </div>

                                <!-- Staff ID -->
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input type="text" class="form-control" id="staffID" name="staffID" required>
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
    {{-- Edit item button --}}
    <script>
        $(document).ready(function(){
            $('.edit-btn').on('click', function(){
                let id = $(this).data('id');                
                fetch(`/api/epf/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.epf){
                        Swal.fire({
                            title: "Edit EPF",
                            html: `
                                <div class='card p-4'>                            
                                    <form id="editItemForm" action="" method="POST">
                                        @csrf    
                                        @method('PUT')                                                         
                                        <!-- Date -->
                                        <div class="mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input value="${data.epf.date}" type="date" class="form-control" id="date" name="date" required>
                                        </div>

                                        <!-- EPF Rate -->
                                        <div class="mb-3">
                                            <label for="EPF_rate" class="form-label">EPF Rate (%)</label>
                                            <input value="${data.epf.EPF_rate}" type="number" class="form-control" id="EPF_rate" name="EPF_rate" min="0" step="0.01" required>
                                        </div>

                                        <!-- Amount -->
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Amount</label>
                                            <input value="${data.epf.amount}" type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
                                        </div>

                                        <!-- Staff ID -->
                                        <div class="mb-3">
                                            <label for="staffID" class="form-label">Staff ID</label>
                                            <input value="${data.epf.staffID}" type="text" class="form-control" id="staffID" name="staffID" required>
                                        </div>

                                        <!-- Submit Button -->
                                        <button id='updateItemSubmit' hidden type="submit" class="btn btn-primary w-100">Submit</button>
                                    </form>

                                <div>

                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.epf.EPFID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/epf/${updateID}/update`);
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