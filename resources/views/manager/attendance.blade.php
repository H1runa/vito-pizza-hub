@extends('layouts.manager')
@section('title', 'Staff Attendance')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Staff Attendance</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Staff Name</th>   
                        <th class="text-center">Status</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Check-In</th>
                        <th class="text-center">Check-Out</th>                                                                                                              
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                </thead>
                <tbody class="text-center">
                    @foreach ($data as $d)
                        <tr>
                            <td class="text-center">{{$d['staff']->firstName.' '.$d['staff']->lastName}}</td>
                            <td class="text-center">{{$d['attendance']->attendanceStatus}}</td>
                            <td class="text-center">{{$d['attendance']->date}}</td>
                            <td class="text-center">{{$d['attendance']->checkInTime}}</td>
                            <td class="text-center">{{$d['attendance']->checkOutTime}}</td>     
                                                                     
                            <td>                                
                                <button class="bg-transparent border-0 delete-btn" >
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('attendance.delete', $d['attendance']->attendID)}}" method="POST">
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
                    title: "Mark Attendance",
                    html: `
                        <div class='card p-4'>                            
                            <form id="attendanceForm" method='POST' action='{{route('attendance.store')}}'>
                                @csrf                                
                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>

                                <!-- Check-in Time -->
                                <div class="mb-3">
                                    <label for="checkInTime" class="form-label">Check-in Time</label>
                                    <input type="time" class="form-control" id="checkInTime" name="checkInTime" >
                                </div>

                                <!-- Check-out Time -->
                                <div class="mb-3">
                                    <label for="checkOutTime" class="form-label">Check-out Time</label>
                                    <input type="time" class="form-control" id="checkOutTime" name="checkOutTime" >
                                </div>

                                <!-- Attendance Status -->
                                <div class="mb-3">
                                    <label for="attendanceStatus" class="form-label">Attendance Status</label>
                                    <select class="form-select" id="attendanceStatus" name="attendanceStatus" required>
                                        <option selected disabled>Select Status</option>
                                        <option value="Attended">Attended</option>
                                        <option value="Absent">Absent</option>
                                    </select>
                                </div>

                                <!-- Staff ID -->
                                <div class="mb-3">
                                    <label for="staffID" class="form-label">Staff ID</label>
                                    <input type="number" class="form-control" id="staffID" name="staffID" required>
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