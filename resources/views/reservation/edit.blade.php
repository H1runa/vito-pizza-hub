<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Reservation</title>
    <script>
        //disables tables with overlapping reservation times
        function checkAvailability(){            
            const date = document.getElementById('date').value;
            const stime = document.getElementById('stime').value;
            const etime = document.getElementById('etime').value;

            let nonoTables = [];

            const reservations = @json($reservations);
            const res = @json($reservation);
         

            reservations.forEach(reservation => {
                if (reservation.resID == res.resID){
                    //this part is here to make sure it doesnt count the current reservation to disable tablesx
                    
                    
                } else {
                    
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
                }                                
            });                      

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
</head>
<body>
    <form id="editReservationForm" action="{{ route('reservation.update', $reservation->resID) }}" method="POST" class="p-4 border shadow-sm bg-light">
        @csrf
        @method('PUT')
    
        <div class="mb-3">
            <label for="customer" class="form-label">Customer Name</label>
            <input required type="text" readonly name="customer" id="customer" value="{{ $customer->firstName }} {{ $customer->lastName }}" class="form-control border-0 shadow-sm">
        </div>
    
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input required type="date" name="date" id="date" value="{{ $reservation->reserveDate }}" class="form-control border-0 shadow-sm" onchange="checkAvailability_EditRes()">
        </div>
    
        <div class="mb-3">
            <label for="stime" class="form-label">Start Time</label>
            <input required type="time" name="stime" id="stime" value="{{ $reservation->startTime }}" class="form-control border-0 shadow-sm" onchange="checkAvailability_EditRes()">
        </div>
    
        <div class="mb-3">
            <label for="etime" class="form-label">End Time</label>
            <input required type="time" name="etime" id="etime" value="{{ $reservation->endTime }}" class="form-control border-0 shadow-sm" onchange="checkAvailability_EditRes()">
        </div>
    
        <div class="mb-3">
            <label for="tableSelect" class="form-label">Table</label>
            <select required name="tableSelect" id="tableSelect" class="form-select border-0 shadow-sm">
                @foreach ($tables as $t)
                    <option value="{{ $t->tableID }}" {{ $reservation->tableID == $t->tableID ? 'selected' : '' }}>
                        Table for {{ $t->seatCount }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
    
    
    {{-- Passing these to the main dashboard --}}
    <script type="application/json" id="reservationData">
        @json($reservation)
    </script>
    <script type="application/json" id="reservationsData">
        @json($reservations)
    </script>
    
</body>
</html>