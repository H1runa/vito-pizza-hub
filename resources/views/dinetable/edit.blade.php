<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Table</title>
</head>
<body>
    <form action="{{route('dinetable.update', $dineTable->tableID)}}" method="POST">
        @csrf
        @method('PUT')
        <h2>Edit Table</h2>
        <label>Seats :</label>
        <input type="number" name="seats" id="seats" value="{{$dineTable->seatCount}}"><br>
        <label>Availability</label>
        <select name="ava" id="ava">
            <option value="True" {{$dineTable->availability == 'True' ? 'selected' : ''}}>True</option>
            <option value="False" {{$dineTable->availability == 'False' ? 'selected' : ''}}>False</option>
        </select>
        <button type="submit">Submit</button>
    </form>
    
</body>
</html>