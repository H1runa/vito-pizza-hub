<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Table</title>
</head>
<body>
    <form id="editTableForm" action="{{ route('dinetable.update', $dineTable->tableID) }}" method="POST" class="p-4 border shadow-sm bg-light">
        @csrf
        @method('PUT')
    
        <div class="mb-3">
            <label for="seats" class="form-label">Seat Count</label>
            <input type="number" class="form-control border-0 shadow-sm" name="seats" id="seats" value="{{ $dineTable->seatCount }}">
        </div>
    
        <div class="mb-3">
            <label for="ava" class="form-label">Availability</label>
            <select class="form-select border-0 shadow-sm" name="ava" id="ava">
                <option value="True" {{ $dineTable->availability == 'True' ? 'selected' : '' }}>True</option>
                <option value="False" {{ $dineTable->availability == 'False' ? 'selected' : '' }}>False</option>
            </select>
        </div>
    </form>
    
    
</body>
</html>