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

    {{-- Scripts from child file --}}
    @stack('scripts') 
</body>
</html>
