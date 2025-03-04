<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
     <!-- Bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
     {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Custom Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

    {{-- Background image --}}
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

    <div class="container-fluid m-0">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand fs-3" href="#" style="font-family: 'Permanent Marker', sans-serif; color: #e63a0f;">
                    Vito Wood Fired Pizza
                </a>
    
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <!-- Restaurant Dropdown -->
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Restaurant
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('manager.menuitems')}}">Menu Items</a></li>
                                <li><a class="dropdown-item" href="{{route('manager.toppings')}}">Extra Toppings</a></li>
                                <li><a class="dropdown-item" href="{{route('manager.offers')}}">Offers</a></li>
                            </ul>
                        </li>
                
                        <!-- Customer Dropdown -->
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Customer
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Customer Returns</a></li>
                                <li><a class="dropdown-item" href="#">Customer Order History</a></li>
                                <li><a class="dropdown-item" href="#">Feedback (View)</a></li>
                            </ul>
                        </li>
                
                        <!-- Staff Dropdown -->
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Staff
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">System Users</a></li>
                                <li><a class="dropdown-item" href="#">Staff</a></li>
                                <li><a class="dropdown-item" href="#">Staff Leaves</a></li>
                                <li><a class="dropdown-item" href="#">Staff Attendance</a></li>
                                <li><a class="dropdown-item" href="#">Service Charge Allowance</a></li>
                                <li><a class="dropdown-item" href="#">Staff ETF</a></li>
                                <li><a class="dropdown-item" href="#">Staff EPF</a></li>
                                <li><a class="dropdown-item" href="#">Salary</a></li>
                                <li><a class="dropdown-item" href="#">Overtime</a></li>
                            </ul>
                        </li>
                
                        <!-- Inventory Dropdown -->
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Inventory
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Suppliers</a></li>
                                <li><a class="dropdown-item" href="#">Supplier Purchases</a></li>
                                <li><a class="dropdown-item" href="#">Supplier Purchase History</a></li>
                                <li><a class="dropdown-item" href="#">Inventory Items</a></li>
                                <li><a class="dropdown-item" href="#">Inventory Orders</a></li>
                                <li><a class="dropdown-item" href="#">Inventory Returns</a></li>
                                <li><a class="dropdown-item" href="#">Delivery People</a></li>
                                <li><a class="dropdown-item" href="#">Delivery Bikes</a></li>
                            </ul>
                        </li>
                
                        <!-- Reports Dropdown -->
                        <li class="nav-item dropdown me-4">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Reports
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Item Trends Report</a></li>
                                <li><a class="dropdown-item" href="#">Sales Report</a></li>
                            </ul>
                        </li>
                    </ul>
                
                    <!-- Profile Dropdown -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-2 text-secondary"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button class="dropdown-item edit-profile-btn" data-id="{{ session('system_user_id') }}">Edit Profile</button>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                
            </div>
        </nav>
        {{-- Success / Fail alerts --}}
        <div>
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
        @yield('content')
    </div>

    
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    {{-- Scripts from child file --}}
    @stack('scripts') 
</body>
</html>
