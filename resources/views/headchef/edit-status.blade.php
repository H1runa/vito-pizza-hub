<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Status</title>
</head>
<body>
    <form method="POST" id="editOrderStatusForm" action="{{ route('order.update', $order->orderID) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="fw-bold">Update Status:</label>
            <div class="btn-group" role="group" aria-label="Order Status">
                <input type="radio" class="btn-check" name="options-outlined" id="placed" value="Placed" autocomplete="off" {{$order->orderStatus == 'Placed' ? 'checked' : ''}}>
                <label class="btn btn-outline-warning" for="placed">Placed</label>
    
                <input type="radio" class="btn-check" name="options-outlined" id="preparing" value="Preparing" autocomplete="off" {{$order->orderStatus == 'Preparing' ? 'checked' : ''}}>
                <label class="btn btn-outline-primary" for="preparing">Preparing</label>
    
                <input type="radio" class="btn-check" name="options-outlined" id="finished" value="Finished" autocomplete="off" {{$order->orderStatus == 'Finished' ? 'checked' : ''}}>
                <label class="btn btn-outline-success" for="finished">Finished</label>
            </div>
        </div>
    </form>
     
</body>
</html>