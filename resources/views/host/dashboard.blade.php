<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Custom Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

    <title>Vito Host Dashboard</title>

    <style>
        body {
            position: relative;
            background: url('{{ asset('images/background.png') }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
        }
    
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.6); /* Semi-transparent black overlay */
            z-index: -1; /* Ensure overlay is behind the content */
        }
    </style>
    
    
</head>
<body>  
    {{-- Success / Fail alerts --}}
    <div class="continer">
        {{-- success --}}
        @if (@session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center fs-5" role="alert">
                {{session('success')}}
                <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
            </div>
        @endif
        {{-- failure --}}
        @if (@session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center fs-5" role="alert">
                {{session('error')}}                
                <button class="btn-close" type="button" data-bs-dismiss='alert'></button>
            </div>
            
        @endif
    </div>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand fs-3" href="#" style="font-family: 'Permanent Marker', sans-serif; color: #e63a0f;">Vito Wood Fired Pizza</a>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            {{-- navbar content goes here --}}
          </ul>
          

          <ul class="dropdown">
              <a class="nav-link dropdown-toggle mt-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-2 text-secondary"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-sm-end">                   
                <button class="dropdown-item edit-profile-btn" data-id="{{session('system_user_id')}}">Edit Profile</button>                        
                <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>                
              </ul>
            </ul>            
        </div>
    </nav>


    <div class="container mx-auto m-5">
        <ul class="nav nav-pills" id="contentTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="reservation-tab" data-bs-toggle='tab' data-bs-target="#reservations" type="button">
                    Reservations
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="table-tab" data-bs-toggle='tab' data-bs-target="#tables" type="button">
                    Tables
                </button>
            </li>               
        </ul>
        <div class="tab-content" id="tabContent">
            <div class="tab-pane fade" id="tables" role="tabpanel">
                <div id="table-list" class="mt-3">                    
                    {{-- Tables List --}}
                    <table border="1" class="datatable table table-bordered">
                        <thead>
                            <tr>                                
                                <th class="text-center">Seat Count</th>
                                <th class="text-center">Availability</th>
                                <th class="text-center">    
                                    Actions: 
                                    <button class="btn p-0 bg-transparent border-0 ms-2 table-add-btn" type="submit">                            
                                        <i class="bi bi-plus-square"></i>
                                    </button>
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dineTable as $t)
                                <tr>
                                    <td class="text-center">{{$t->seatCount}}</td>
                                    <td class="text-center">{{$t->availability}}</td>
                                    <td class="d-flex align-items-center justify-content-center">
                                        <button class="btn p-0 bg-transparent border-0 edit-btn me-2" data-id='{{$t->tableID}}'>
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>
                                        <button onclick="confirmDelete(this)" class="btn p-0 bg-transparent border-0" type="submit"><i class="bi bi-trash text-danger"></i></button>
                                        <form method="POST" action="{{route('dinetable.delete', $t->tableID)}}">
                                            @csrf
                                            @method('DELETE')                                            
                                        </form>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade show active" id="reservations" role="tabpanel">
                <div id="reservation-list" class="mt-3">
                    {{-- <h3>Reservation List</h3> --}}
                    <table border="1" class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th class='text-center'>Customer</th>
                                <th class='text-center'>Date</th>
                                <th class='text-center'>Start Time</th>                                        
                                <th class='text-center'>End Time</th>
                                <th class='text-center'>                                                                        
                                        Actions: 
                                        <button type="submit" class="btn bg-transparent p-0 border-0 reservation-add-btn"><i class="bi bi-plus-square ms-2"></i></button>                                    
                                </th>                                                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $r)
                                <tr>
                                    <td class='text-center'>{{$r->customer->firstName ?? 'Not'}} {{$r->customer->lastName ?? 'Found'}}</td>
                                    <td class='text-center'>{{$r->reserveDate}}</td>
                                    <td class='text-center'>{{$r->startTime}}</td>
                                    <td class='text-center'>{{$r->endTime}}</td>
                                    <td class='d-flex justify-content-center align-items-center'>
                                        <button class="btn p-0 bg-transparent border-0 reservation-edit-btn me-2" data-id='{{$r->resID}}'>
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>
                                        <button onclick="confirmDelete(this)" type="submit" class="btn bg-transparent border-0 p-0"><i class="bi bi-trash text-danger"></i></button>
                                        <form action="{{route('reservation.delete', $r->resID)}}" method="POST">
                                            @csrf
                                            @method('DELETE')                                            
                                        </form>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>   
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="pageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="editModalTitle">Title here</h5> --}}
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>



    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>    
         
    {{-- Initializing the DataTables --}}
    <script>
        $(document).ready(function() {            
            $('.datatable').DataTable({
                responsive:true
            });
        });
    </script>

    {{-- Edit Table Modal Script --}}
    <script>
        $(document).ready(function(){
            $('.edit-btn').on('click', function(){
                let tableID = $(this).data('id');
                let url = '/dinetable/'+tableID+'/edit';

                // alert(tableID);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'text/html'
                    }
                })
                .then(response => {
                    if (!response.ok){
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html=>{
                    Swal.fire({
                        title: "Edit Table",
                        html: html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: () => {
                            if($('#editTableForm')[0].checkValidity()){
                                $('#editTableForm').submit();
                            } else {
                                Swal.showValidationMessage('Please fill out all the required fields');
                                return false;
                            };                            
                        }
                    })
                })
                .catch(error=>{
                    console.error('Error loading the edit form', error);
                    alert('Edit form not loaded');
                })
            })
        })
    </script>

    {{-- Edit Profile Modal --}}
    <script>
        $(document).ready(function(){
            $('.edit-profile-btn').on('click', function(){
                let staffID = $(this).data('id');
                let url = '/profile/'+staffID+'/edit';

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'Application/json'
                    }
                })
                .then(response=>{
                    if(!response.ok){
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data=>{
                    Swal.fire({
                        title: 'Edit Profile',
                        html: data.html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: ()=>{                            
                            if ($('#editProfileForm')[0].checkValidity()){
                                $('#editProfileForm').submit();
                            } else {
                                Swal.showValidationMessage('Username must be filled out');
                                return false;
                            }
                        },
                        
                    })
                }).catch(error=>{
                    console.error('Edit profile error: ',error);
                })
            })
        })
    </script>

    {{-- Add Table Modal Script --}}
    <script>
        $(document).ready(function(){
            $('.table-add-btn').on('click', function(){                
                let url = '/dinetable/create';               
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'text/html'
                    }
                })
                .then(response => {
                    if (!response.ok){
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html=>{
                    Swal.fire({
                        title: "Add Table",
                        html: html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: () => {
                            if ($('#addTableForm')[0].checkValidity()) {                                
                                $('#addTableForm').submit();
                            } else {
                                Swal.showValidationMessage('Please fill out all required fields');
                                return false;
                            }
                        }

                    })
                })
                .catch(error=>{
                    console.error('Error loading the edit form', error);
                    alert('Edit form not loaded');
                })
            })
        })
    </script>

    {{-- Edit Reservation Modal Script --}}
    <script>
        $(document).ready(function(){
            $('.reservation-edit-btn').on('click', function(){
                let resID = $(this).data('id');
                let url = '/reservation/'+resID+'/edit';

                // alert(tableID);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'Application/json'
                    }
                })
                .then(response => {
                    if (!response.ok){
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data=>{
                    Swal.fire({
                        title: 'Edit Reservation',
                        html: data.html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: ()=>{
                            if($('#editReservationForm')[0].checkValidity()){
                                $('#editReservationForm').submit();
                            } else {
                                Swal.showValidationMessage('Please fill out all the fields');
                                return false;
                            }
                            
                        },
                        
                    })
                })
                .catch(error=>{
                    console.error('Error loading the edit form', error);
                    alert('Edit form not loaded');
                })
            })
        })
    </script>

    {{-- Add Reservation Modal Script --}}
    <script>
        $(document).ready(function(){
            $('.reservation-add-btn').on('click', function(){                
                let url = '/reservation/create';               
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'Application/json'
                    }
                })
                .then(response => {
                    if (!response.ok){
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data=>{      
                    //console.log(data.reservations);              
                    Swal.fire({
                        title: "Add Reservation",
                        html: data.html,
                        showCancelButton: true,
                        focusConfirm: false,
                        preConfirm: () => {
                            if($('#addReservationForm')[0].checkValidity()){
                                $('#addReservationForm').submit();
                            } else {
                                Swal.showValidationMessage('Please fill out all the required fields');
                                return false;
                            }
                            
                        },
                        didOpen: ()=>{
                            const modal = Swal.getPopup();
                            modal.querySelector('#checkForCustomer').addEventListener('click', async function(){
                                getFullCustomerName();
                            });
                        }
                        
                        
                    });

                    
                })
                .catch(error=>{
                    console.error('Error loading the edit form', error);
                    alert('Edit form not loaded');
                })
            })
        })                               
    </script>

    

    {{-- Script for add reservation --}}
    <script>
       
        // Disable tables with overlapping reservation times
        function checkAvailability() {            
            const date = document.getElementById("date").value;
            const stime = document.getElementById("stime").value;
            const etime = document.getElementById("etime").value;

            //if (!date || !stime || !etime) return;

            let nonoTables = [];

            const reservations = @json($reservations);

            reservations.forEach(reservation => {            
                const rDate = reservation.reserveDate;
                const rStime = reservation.startTime;
                const rEtime = reservation.endTime;

                if (date === rDate) {
                    if ((stime >= rStime && stime <= rEtime) || (etime <= rEtime && etime >= rStime)) {
                        nonoTables.push(reservation.tableID);
                    }
                }
            });

            // Disable conflicting tables
            const tableSelect = document.getElementById("tableSelect");
            for (let opt of tableSelect.options) {
                opt.disabled = nonoTables.includes(parseInt(opt.value));
            }
        }
 
    </script>

    {{-- Script for edit reservation --}}
    <script>
        //disables tables with overlapping reservation times
        function checkAvailability_EditRes(){                            
            const date = document.getElementById('date').value;
            const stime = document.getElementById('stime').value;
            const etime = document.getElementById('etime').value;

            let nonoTables = [];

            const reservations = JSON.parse(document.getElementById('reservationsData').textContent);
            
            const res = JSON.parse(document.getElementById('reservationData').textContent);

         

            reservations.forEach(reservation => {
                if (reservation.resID == res.resID){
                    //this part is here to make sure it doesnt count the current reservation to disable tablesx
                    
                    
                } else {
                    
                    const r_date = reservation.reserveDate;
                    const r_stime = reservation.startTime;
                    const r_etime = reservation.endTime;

                    if(date==r_date){
                        
                        if(stime>=r_stime && stime<=r_etime){
                            nonoTables.push(reservation.tableID);
                        } else if (etime<=r_etime && etime>=r_stime){
                            nonoTables.push(reservation.tableID);
                        }
                    }
                }                                
            });                      

            const tableSelect = document.getElementById('tableSelect');
            for(let opt of tableSelect.options){
                if(nonoTables.includes(parseInt(opt.value))){
                    opt.disabled = true;
                   
                } else if (opt.value != '') {
                    opt.disabled = false;
                }
            }
        }
    </script>    

    {{-- Get full customer name --}}
    <script>
        async function getFullCustomerName(){
            const enteredUsername = document.getElementById("customer").value;
            if (!enteredUsername) return;

            const url = new URL("{{route('api.customer.name')}}");
            url.searchParams.append("username", enteredUsername);

            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error("Network error");

                const data = await response.json();
                document.getElementById("fullname").value = data.fullName;
            } catch (error) {
                console.error("Fetch error:", error);
                document.getElementById("fullname").value = "Invalid";
            }
            }
    </script>

    {{-- sure you want to delete? button function --}}
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: "Are you sure?",
                text: "Please note that the reservations associated with this table will be deleted as well",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    button.nextElementSibling.submit(); // Submit the form
                }
            });
        }
    </script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    
</body>
</html>