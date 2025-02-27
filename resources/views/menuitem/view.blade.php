<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Item</title>
</head>
<body>
    <div class="menu-card">        
        <p>Price : Rs.{{$item->price}}</p>
        <p>Category : {{$item->category}}</p>
        <p>Size : {{$item->size}}</p>
        <p>Availability : {{$item->availability}}</p>
        <p>Path: {{ asset('storage/' . $item->image) }}</p>
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->itemName }}" width="200">
    </div>
</body>
</html>