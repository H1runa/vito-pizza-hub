<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Item List</title>
</head>
<body>
    @foreach ($items as $item)
        <button data-id="{{$item->menuID}}" data-orderid='{{$order->orderID}}' class="btn btn-info viewItemBtn">
            {{$item->itemName}} x {{$item->pivot->quantity}}
        </button>
    @endforeach
</body>
</html>