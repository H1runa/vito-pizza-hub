<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Item</title>
</head>
<body>
    <div class="container my-4">
        <div class="card shadow-sm">
            <!-- Image with padding -->
            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top p-3" alt="{{ $item->itemName }}" width="200">
            <div class="card-body">
                {{-- <h5 class="card-title text-center">{{ $item->itemName }}</h5> --}}
                <div class="row">
                    <!-- Price -->
                    <div class="col-6 d-flex justify-content-between">
                        <strong>Price:</strong>
                        <span>Rs.{{$item->price}}</span>
                    </div>
                    <!-- Category -->
                    <div class="col-6 d-flex justify-content-between">
                        <strong>Category:</strong>
                        <span>{{$item->category}}</span>
                    </div>
                    <!-- Size -->
                    <div class="col-6 d-flex justify-content-between">
                        <strong>Size:</strong>
                        <span>{{$item->size}}</span>
                    </div>
                    <!-- Availability -->
                    <div class="col-6 d-flex justify-content-between">
                        <strong>Availability:</strong>
                        <span>{{$item->availability}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>




</html>