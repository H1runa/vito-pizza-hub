<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    

    {{-- Background image --}}
    <style>
        body {
            position: relative;
            background: url('{{ asset('images/login_background.jpg') }}') no-repeat center center fixed;
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
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg rounded-3" style="width: 100%; max-width: 400px;">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Staff Login</h2>
    
                @if(session('error'))
                    <div class="alert alert-danger bg-light border-0 text-danger">
                        {{ session('error') }}
                    </div>
                @endif
    
                @if ($errors->any())
                    <div class="alert alert-danger bg-light border-0 text-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required autofocus>
                    </div>
    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb1Uj+dX+g8wE2v3Pp5Z5D5j62YZDkpI3M4V9tSgV4Atu4dxB" crossorigin="anonymous"></script>
   {{-- Bootstrap JS --}}
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        
</html>
