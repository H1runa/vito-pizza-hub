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
    <form action="{{route('reservation.update', $reservation->resID)}}" method="POST">
        @csrf
        @method('PUT')
        <h2>Reservation</h2>
        <label>Customer Name :</label>
        <input type="text" readonly name="customer" id="customer" value="{{$customer->firstName}} {{$customer->lastName}} "><br>
        <label>Date :</label>
        <input type="date" name="date" id="date" value="{{$reservation->reserveDate}}" onchange="checkAvailability()"><br>
        <label>Start Time :</label>
        <input type="time" name="stime" id="stime" value="{{$reservation->startTime}}" onchange="checkAvailability()"><br>
        <label>End Time :</label>
        <input type="time" name="etime" id="etime" value="{{$reservation->endTime}}" onchange="checkAvailability()"><br>
        <label>Table :</label>
        <select name="tableSelect" id="tableSelect">
            @foreach ($tables as $t)
                <option value="{{$t->tableID}}" {{$reservation->tableID==$t->tableID ? 'selected' : ''}}>Table for {{$t->seatCount}}</option>
            @endforeach
        </select><br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>