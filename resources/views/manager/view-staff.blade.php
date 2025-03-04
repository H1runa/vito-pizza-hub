@extends('layouts.manager')
@section('title', 'Staff Members')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Staff Members</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">ID</th>                                                
                        <th class="text-center">Name</th>                        
                        <th class="text-center">Job Title</th>    
                        <th class="text-center">DOB</th>   
                        <th class="text-center">NIC</th> 
                        <th class="text-center">Address</th>            
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($staff as $s)
                        <tr>
                            <td class="text-center">{{$s->staffID}}</td>                            
                            <td class="text-center">{{$s->firstName.' '.$s->lastName}}</td>
                            <td class="text-center">{{$s->jobTitle}}</td>
                            <td class="text-center">{{$s->DOB}}</td>
                            <td class="text-center">{{$s->NIC}}</td>
                            <td class="text-center">{{$s->addressLine1}}, <br>
                                {{$s->addressLine2}}, <br>
                                {{$s->addressLine3}}</td>                                                                                                                                  
                            <td>
                                <button class="bg-transparent border-0 edit-btn" data-id="{{$s->staffID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn" data-id="{{$s->staffID}}">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('staff.delete' , $s->staffID)}}" method="POST">
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
                    title: "Add Staff",
                    html: `
                        <form id="staffForm" action='{{route('staff.create')}}' method='POST'> 
                            @csrf                           
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                            <div class="mb-3">
                                <label for="jobTitle" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
                            </div>
                            <div class="mb-3">
                                <label for="DOB" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="DOB" name="DOB" required>
                            </div>
                            <div class="mb-3">
                                <label for="NIC" class="form-label">NIC</label>
                                <input type="text" class="form-control" id="NIC" name="NIC" required>
                            </div>
                            <div class="mb-3">
                                <label for="addressLine1" class="form-label">Address Line 1</label>
                                <input type="text" class="form-control" id="addressLine1" name="addressLine1" required>
                            </div>
                            <div class="mb-3">
                                <label for="addressLine2" class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" id="addressLine2" name="addressLine2">
                            </div>
                            <div class="mb-3">
                                <label for="addressLine3" class="form-label">Address Line 3</label>
                                <input type="text" class="form-control" id="addressLine3" name="addressLine3">
                            </div>
                            <div class="d-grid">
                                <button hidden id='addItemSubmit' type="submit" class="btn btn-primary">Submit</button>
                            </div>
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
     {{-- Edit item button --}}
     <script>
        $(document).ready(function(){
            $('.edit-btn').on('click', function(){
                let id = $(this).data('id');                
                fetch(`/api/staff/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.staff){
                        Swal.fire({
                            title: "Edit Staff",
                            html: `
                                <form id="editItemForm" action='' method='POST'> 
                                    @csrf        
                                    @method('PUT')                   
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input value='${data.staff.firstName}' type="text" class="form-control" id="firstName" name="firstName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input value=${data.staff.lastName} type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jobTitle" class="form-label">Job Title</label>
                                        <input value=${data.staff.jobTitle} type="text" class="form-control" id="jobTitle" name="jobTitle" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="DOB" class="form-label">Date of Birth</label>
                                        <input value=${data.staff.DOB} type="date" class="form-control" id="DOB" name="DOB" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="NIC" class="form-label">NIC</label>
                                        <input value=${data.staff.NIC} type="text" class="form-control" id="NIC" name="NIC" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="addressLine1" class="form-label">Address Line 1</label>
                                        <input value=${data.staff.addressLine1} type="text" class="form-control" id="addressLine1" name="addressLine1" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="addressLine2" class="form-label">Address Line 2</label>
                                        <input value=${data.staff.addressLine2} type="text" class="form-control" id="addressLine2" name="addressLine2">
                                    </div>
                                    <div class="mb-3">
                                        <label for="addressLine3" class="form-label">Address Line 3</label>
                                        <input value=${data.staff.addressLine3} type="text" class="form-control" id="addressLine3" name="addressLine3">
                                    </div>
                                    <div class="d-grid">
                                        <button hidden id='updateItemSubmit' type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.staff.staffID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/staff/${updateID}/update`);
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