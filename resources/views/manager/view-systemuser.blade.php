@extends('layouts.manager')
@section('titile', 'System Users')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">System Users</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Staff ID</th>                                                
                        <th class="text-center">Name</th>
                        <th class="text-center">Username</th>                             
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i data-users='{{$noLogin}}' class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($sysusers as $s)
                        <tr>
                            <td>{{ $s['staff']->staffID}}</td>                                                        
                            <td>{{ $s['staff']->firstName.' '.$s['staff']->lastName}}</td>                                                        
                            <td>{{ $s['user']->username }}</td>                                                        
                                                       
                            <td>
                                <button class="bg-transparent border-0 edit-btn" data-users='{{$noLogin}}' data-id="{{$s['staff']->staffID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('systemuser.delete', $s['user']->staffID)}}" method="POST">
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
                let users_b = $(this).data('users');     
                
                let userHtml = '';
                users_b.forEach(function(user) {
                    userHtml += `
                        <option class='text-center' value='${user.staffID}'>${user.firstName} ${user.lastName}</option>
                    `;
                });
               
                Swal.fire({
                    title: "Add System User",
                    html: `
                        <div class='card p-4'>
                            <form id="userForm" method='POST' action="{{route('systemuser.create')}}">
                                @csrf
                                
                                <!-- Username -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input class='text-center' type="text" class="form-control" id="username" name="username" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input class='text-center' type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <!-- Select Option -->
                                <div class="mb-3">
                                    <label for="userType" class="form-label">Select Staff</label>
                                    <select class="form-select" id="userType" name="userType" required>
                                        ${userHtml}
                                    </select>
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
    {{-- Edit item button --}}
    <script>
        $(document).ready(function(){
            $('.edit-btn').on('click', function(){
                let id = $(this).data('id');                
                fetch(`/api/systemuser/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.user){
                        Swal.fire({
                            title: "Edit System User",
                            html: `
                                <div class='card p-4'>
                                    <form id="editItemForm" method='POST' action="">
                                        @csrf
                                        @method('PUT')
                                        <!-- Username -->
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input value='${data.user.username}' class='text-center' type="text" class="form-control" id="username" name="username" required>
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input class='text-center' type="password" class="form-control" id="password" name="password" required>
                                        </div>                                            

                                        <!-- Submit Button -->
                                        <button hidden id='updateItemSubmit' type="submit" class="btn btn-primary w-100">Submit</button>
                                    </form>

                                <div>
                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.user.staffID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/systemuser/${updateID}/update`);
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