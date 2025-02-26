<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Reservation</title>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    
</head>
<body>
    {{-- <h2>Add Reservation</h2> --}}
    <div id="content">
        <form id="addReservationForm" action="{{ route('reservation.store') }}" method="POST" class="p-4 border shadow-sm bg-light">
            @csrf
            <div class="mb-3">
                <label for="customer" class="form-label">Username</label>
                <div class="d-flex">
                    <input required type="text" name="customer" id="customer" class="form-control border-0 shadow-sm">
                    <a href="#" id="checkForCustomer" class="btn btn-primary ms-2 shadow-sm"><i class="bi bi-search"></i></a>
                </div>
            </div>
        
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input required type="text" name="fullname" id="fullname" class="form-control border-0 shadow-sm" readonly>
            </div>
        
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input required type="date" name="date" id="date" class="form-control border-0 shadow-sm" onchange="checkAvailability()">
            </div>
        
            <div class="mb-3">
                <label for="stime" class="form-label">Start Time</label>
                <input required type="time" name="stime" id="stime" class="form-control border-0 shadow-sm" onchange="checkAvailability()">
            </div>
        
            <div class="mb-3">
                <label for="etime" class="form-label">End Time</label>
                <input required type="time" name="etime" id="etime" class="form-control border-0 shadow-sm" onchange="checkAvailability()">
            </div>
        
            <div class="mb-3">
                <label for="tableSelect" class="form-label">Table</label>
                <select required name="tableSelect" id="tableSelect" class="form-select border-0 shadow-sm">
                    <option value="" disabled selected>Show available tables</option>
                    @foreach ($tables as $t)
                        <option value="{{ $t->tableID }}">Seats: {{ $t->seatCount }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        
    
    </div>
    
    @section('scripts')
    <script>
        document.getElementById('checkForCustomer').addEventListener('click', async function(e){
            e.preventDefault();

            const entered_username = document.getElementById('customer').value;
            const url = new URL('{{route('api.customer.name')}}');
            url.searchParams.append('username', entered_username);

            try{
                const response = await fetch(url);
                if(!response.ok){
                    throw new Error('Network error');
                }
                const data = await response.json();
                document.getElementById('fullname').value = data.fullName;
            } catch (error){
                console.error('Fetch error:', error);
                document.getElementById('fullname').value = "Invalid";
            }
        })
    </script>
    <script>
        //disables tables with overlapping reservation times
        function checkAvailability(){            
            const date = document.getElementById('date').value;
            const stime = document.getElementById('stime').value;
            const etime = document.getElementById('etime').value;

            let nonoTables = [];

            const reservations = @json($reservations);

            reservations.forEach(reservation => {
                const r_date = reservation.reserveDate;
                const r_stime = reservation.startTime;
                const r_etime = reservation.endTime;

                if(date==r_date){
                    if(stime>=r_stime && stime<=r_etime){
                        nonoTables.push(reservation.tableID);
                    } else if (etime<=r_etime && etime>=r_stime){
                        nonoTables.push(reservation.tableID);
                    }
                }
            });

          
            //alert(nonoTables[0]);

            const tableSelect = document.getElementById('tableSelect');
            for(let opt of tableSelect.options){
                if(nonoTables.includes(parseInt(opt.value))){
                    opt.disabled = true;
                   
                } else if (opt.value != '') {
                    opt.disabled = false;
                }
            }
        }
    </script>
    @endsection
    
</body>
</html>