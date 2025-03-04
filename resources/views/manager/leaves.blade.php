@extends('layouts.manager')
@section('title', 'Staff Leaves')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Staff Leave</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Staff</th>   
                        <th class="text-center">Type</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Reason</th>                                      
                        <th class="text-center">Deduct Amount</th>                            
                        <th class="text-center">Salary ID</th>     
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                </thead>
                <tbody class="text-center">
                    @foreach ($data as $d)
                        <tr>
                            <td class="text-center">{{$d['staff']->firstName.' '.$d['staff']->lastName}}</td>
                            <td class="text-center">{{$d['leave']->leaveType}}</td>
                            <td class="text-center">{{$d['leave']->leaveDate}}</td>
                            <td class="text-center">{{$d['leave']->duration}}</td>
                            <td class="text-center">{{$d['leave']->reason}}</td>     
                            <td class="text-center">{{$d['leave']->deductAmount}}</td>   
                            <td class="text-center">{{$d['leave']->salaryID}}</td>              
                            <td>
                                <button class="bg-transparent border-0 edit-btn" data-id="{{$d['leave']->leaveID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn" >
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('leave.delete', $d['leave']->leaveID)}}" method="POST">
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
                    title: "Add Leave",
                    html: `
                        <div class='card p-4'>                            
                            <form id="leaveForm" method='POST' action='{{route("leave.store")}}'>
                                @csrf
                                <!-- Staff ID -->
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input type="text" class="form-control" id="staffID" name="staffID" required>
                                </div>

                                <!-- Leave Type -->
                                <div class="mb-3">
                                    <label for="leaveType" class="form-label">Leave Type</label>
                                    <select class="form-select" id="leaveType" name="leaveType" required>
                                        <option selected disabled>Select Leave Type</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>                                        
                                    </select>
                                </div>

                                <!-- Leave Date -->
                                <div class="mb-3">
                                    <label for="leaveDate" class="form-label">Leave Date</label>
                                    <input type="date" class="form-control" id="leaveDate" name="leaveDate" required>
                                </div>

                                <!-- Duration -->
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration (Days)</label>
                                    <input type="number" class="form-control" id="duration" name="duration" required min="1">
                                </div>

                                <!-- Reason -->
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                </div>

                                <!-- Deduct Amount -->
                                <div class="mb-3">
                                    <label for="deductAmount" class="form-label">Deduct Amount</label>
                                    <input type="number" class="form-control" id="deductAmount" name="deductAmount" required min="0">
                                </div>

                                <!-- Salary ID -->
                                <div class="mb-3">
                                    <label for="salaryID" class="form-label">Salary ID</label>
                                    <input type="text" class="form-control" id="salaryID" name="salaryID" required>
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
                fetch(`/api/leave/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.leave){
                        Swal.fire({
                            title: "Edit EPF",
                            html: `
                                <div class='card p-4'>                            
                                    <form id="editItemForm" method='POST' action=''>
                                        @csrf
                                        @method('PUT')
                                        <!-- Staff ID -->
                                        <div class="mb-3">
                                            <label for="staffID" class="form-label">Staff ID</label>
                                            <input value='${data.leave.staffID}' type="text" class="form-control" id="staffID" name="staffID" required>
                                        </div>

                                        <!-- Leave Type -->
                                        <div class="mb-3">
                                            <label for="leaveType" class="form-label">Leave Type</label>
                                            <select class="form-select" id="leaveType" name="leaveType" required>
                                                <option disabled>Select Leave Type</option>
                                                <option ${data.leave.leaveType == 'Paid' ? 'selected' : ''} value="Paid">Paid</option>
                                                <option ${data.leave.leaveType == 'Unpaid' ? 'selected' : ''} value="Unpaid">Unpaid</option>                                        
                                            </select>
                                        </div>

                                        <!-- Leave Date -->
                                        <div class="mb-3">
                                            <label for="leaveDate" class="form-label">Leave Date</label>
                                            <input value='${data.leave.leaveDate}' type="date" class="form-control" id="leaveDate" name="leaveDate" required>
                                        </div>

                                        <!-- Duration -->
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration (Days)</label>
                                            <input value='${data.leave.duration}' type="number" class="form-control" id="duration" name="duration" required min="1">
                                        </div>

                                        <!-- Reason -->
                                        <div class="mb-3">
                                            <label for="reason" class="form-label">Reason</label>
                                            <textarea class="form-control" id="reason" name="reason" rows="3" required>${data.leave.reason}</textarea>
                                        </div>

                                        <!-- Deduct Amount -->
                                        <div class="mb-3">
                                            <label for="deductAmount" class="form-label">Deduct Amount</label>
                                            <input value='${data.leave.deductAmount}' type="number" class="form-control" id="deductAmount" name="deductAmount" required min="0">
                                        </div>

                                        <!-- Salary ID -->
                                        <div class="mb-3">
                                            <label for="salaryID" class="form-label">Salary ID</label>
                                            <input value='${data.leave.salaryID}' type="text" class="form-control" id="salaryID" name="salaryID" required>
                                        </div>

                                        <!-- Submit Button -->
                                        <button id='updateItemSubmit' hidden type="submit" class="btn btn-primary w-100">Submit</button>
                                    </form>


                                <div>
                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.leave.leaveID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/leave/${updateID}/update`);
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