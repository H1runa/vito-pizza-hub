<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Table</title>
</head>
<body>
    {{-- <h3>Add Table</h3> --}}
    <form id="addTableForm" action="{{ route('dinetable.store') }}" method="POST" class="p-4 border shadow-sm bg-light">
      @csrf
      <div class="mb-3">
          <label for="seats" class="form-label">Seat Count</label>
          <input required type="number" class="form-control border-0 shadow-sm" name="seats" id="seats">
      </div>
  
      <div class="mb-3">
          <label for="ava" class="form-label">Availability</label>
          <select required class="form-select border-0 shadow-sm" name="ava" id="ava">
              <option value="True">True</option>
              <option value="False">False</option>
          </select>
      </div>
    </form>
  
  
</body>
</html>