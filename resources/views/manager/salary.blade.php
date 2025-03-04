@extends('layouts.manager')
@section('title', 'Salary')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Staff Salary</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Staff Name</th>
                        <th class="text-center">Base Salary</th>
                        <th class="text-center">Fixed Allowance</th>
                        <th class="text-center">Net Salary</th>
                        <th class="text-center">Date Issued</th>                        
                        <th class="text-center">Actions: <button class="bg-transparent border-0"><i class="text-light bi bi-plus-square-fill addItemBtn"></i></button></th>                  
                </thead>
                <tbody class="text-center">
                    @foreach ($salaries as $s)
                        <tr>
                            <td class="text-center">{{$s['staff']->firstName.' '.$s['staff']->lastName}}</td>
                            <td class="text-center">{{$s['salary']->baseSalary}}</td>
                            <td class="text-center">{{$s['salary']->fixedAllowance}}</td>
                            <td class="text-center">{{$s['salary']->netSalary}}</td>
                            <td class="text-center">{{$s['salary']->dateIssued}}</td>
                            <td>
                                <button class="bg-transparent border-0 edit-btn" data-id="{{$s['salary']->salaryID}}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button class="bg-transparent border-0 delete-btn" ">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                                <form id="deleteForm" action="{{route('salary.delete', $s['salary']->salaryID)}}" method="POST">
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
                    title: "Add Salary",
                    html: `
                        <form id="salaryForm" method='POST' action='{{route('salary.store')}}'>
                            @csrf
                            <!-- Base Salary -->
                            <div class="mb-3">
                                <label for="baseSalary" class="form-label">Base Salary</label>
                                <input type="number" class="form-control" id="baseSalary" name="baseSalary" required>
                            </div>

                            <!-- Fixed Allowance -->
                            <div class="mb-3">
                                <label for="fixedAllowance" class="form-label">Fixed Allowance</label>
                                <input type="number" class="form-control" id="fixedAllowance" name="fixedAllowance" required>
                            </div>

                            <!-- Net Salary -->
                            <div class="mb-3">
                                <label for="netSalary" class="form-label">Net Salary</label>
                                <input type="number" class="form-control" id="netSalary" name="netSalary" required>
                            </div>

                            <!-- Date Issued -->
                            <div class="mb-3">
                                <label for="dateIssued" class="form-label">Date Issued</label>
                                <input type="date" class="form-control" id="dateIssued" name="dateIssued" required>
                            </div>

                            <!-- Staff ID -->
                            <div class="mb-3">
                                <label for="staffID" class="form-label">Staff ID</label>
                                <input type="number" class="form-control" id="staffID" name="staffID" required>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" hidden id="addItemSubmit" class="btn btn-primary w-100">Submit</button>
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
                fetch(`/api/salary/${id}/get`)
                .then(response=>response.json())
                .then(data=>{
                    if(data.salary){
                        Swal.fire({
                            title: "Edit Salary",
                            html: `
                                <div class='card p-4'>
                                    <form id="editItemForm" method='POST' action='{{route('salary.store')}}'>
                                        @csrf
                                        @method('PUT')
                                        <!-- Base Salary -->
                                        <div class="mb-3">
                                            <label for="baseSalary" class="form-label">Base Salary</label>
                                            <input value='${data.salary.baseSalary}' type="number" class="form-control" id="baseSalary" name="baseSalary" required>
                                        </div>

                                        <!-- Fixed Allowance -->
                                        <div class="mb-3">
                                            <label for="fixedAllowance" class="form-label">Fixed Allowance</label>
                                            <input value='${data.salary.fixedAllowance}' type="number" class="form-control" id="fixedAllowance" name="fixedAllowance" required>
                                        </div>

                                        <!-- Net Salary -->
                                        <div class="mb-3">
                                            <label for="netSalary" class="form-label">Net Salary</label>
                                            <input value='${data.salary.netSalary}' type="number" class="form-control" id="netSalary" name="netSalary" required>
                                        </div>

                                        <!-- Date Issued -->
                                        <div class="mb-3">
                                            <label for="dateIssued" class="form-label">Date Issued</label>
                                            <input value='${data.salary.dateIssued}' type="date" class="form-control" id="dateIssued" name="dateIssued" required>
                                        </div>

                                        <!-- Staff ID -->
                                        <div class="mb-3">
                                            <label for="staffID" class="form-label">Staff ID</label>
                                            <input value='${data.salary.staffID}' type="number" class="form-control" id="staffID" name="staffID" required>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" hidden id="updateItemSubmit" class="btn btn-primary w-100">Submit</button>
                                    </form>
                                <div>
                            `,
                            showCancelButton: true,
                            focusConfirm: false,
                            preConfirm: () => {
                                    let updateID = data.salary.salaryID;
                                    // alert(updateID);
                                    $('#editItemForm').attr('action', `/salary/${updateID}/update`);
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