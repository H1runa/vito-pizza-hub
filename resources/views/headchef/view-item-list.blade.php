<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Item List</title>
</head>
<body>
    <div class="container my-4">
        <div class="list-group">
            @foreach ($items as $item)
                <button 
                    data-id="{{$item->menuID}}" 
                    data-orderid='{{$order->orderID}}' 
                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center viewItemBtn">
                    <span>{{$item->itemName}}</span>
                    <span class="badge bg-primary rounded-pill">{{$item->pivot->quantity}}</span>
                </button>
            @endforeach
        </div>
    </div>
</body>

</html>