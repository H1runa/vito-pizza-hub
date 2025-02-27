<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Profile</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    

</head>
<body>
    <form method="POST" id="editProfileForm" action="{{ route('profile.update', [$sysuser->staffID, session('job_title')]) }}" class="p-4 border rounded-3 shadow-sm bg-light">
        @csrf
        @method('PUT')
    
        <div class="mb-3">
            <label for="username" class="form-label fw-medium">Username</label>
            <input required type="text" name="username" id="username" value="{{ $sysuser->username }}" class="form-control border-0 shadow-sm p-2">
        </div>
    
        {{-- <div class="mb-3 px-2 py-1 bg-white rounded-2 shadow-sm">
            <small class="text-muted d-block text-center">Fill in password fields only if changing your current password</small>
        </div> --}}
    
        <div class="mb-3">
            <label for="newpassword" class="form-label fw-medium">New Password</label>
            <input type="password" name="newpassword" id="newpassword" class="form-control border-0 shadow-sm p-2">
        </div>
    
        <div class="mb-3">
            <label for="oldpassword" class="form-label fw-medium">Old Password</label>
            <input type="password" name="oldpassword" id="oldpassword" class="form-control border-0 shadow-sm p-2">
        </div>
    </form>
    
    

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        
</body>
</html>