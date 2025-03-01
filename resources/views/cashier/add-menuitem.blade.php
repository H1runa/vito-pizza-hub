<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Menu Item</title>    
</head>
<body>
    <div class="container mt-5">         
        <form method="GET" id="quantitySelectionForm" action="{{ route('cashier.additem', $item->menuID) }}">
            @csrf   
            <div class="mb-3">
                <label for="itemQuantity" class="form-label">Quantity</label>
                <input id="itemQuantity" type="number" name="quantity" class="form-control" required>
            </div>        
            <div class="mb-3">
                <label for="topping" class="form-label">Toppings</label>
                <select name="topping" id="topping" class="form-select" required>
                    @foreach ($toppings as $topping)
                        <option value="{{ $topping->toppingID }}">{{ $topping->toppingName }}</option>
                    @endforeach
                </select>
            </div>            
        </form>
    </div>

    
</body>
</html>
