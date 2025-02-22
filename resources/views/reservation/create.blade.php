<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Reservation</title>
    <script>
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
                    if(stime>=r_stime && etime<=r_etime){
                        nonoTables.push(reservation.tableID);
                    } else if (etime<=r_etime && etime>=r_etime){
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
</head>
<body>
    <h2>Add Reservation</h2>
    <form action="{{route('reservation.store')}}" method="POST">
        @csrf
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $er)
                    <li>{{$er}}</li>
                @endforeach
            </ul>            
        @endif
        <label>Customer Username: </label>
        <input type="text" name="customer" id="customer">
        <a href="" id="checkForCustomer">Check</a><br>
        <label>Customer Name: </label>
        <input type="text" name="fullname" id="fullname" readonly><br>
        <label>Date: </label>
        <input type="date" name="date" onchange="checkAvailability()" id="date"><br>
        <label>Start Time: </label>
        <input type="time" name="stime" onchange="checkAvailability()" id="stime"><br>
        <label>End Time: </label>
        <input type="time" name="etime" onchange="checkAvailability()" id="etime"><br>        
        <label>Table: </label>
        <select name="tableSelect" id="tableSelect">
            <option value="" disabled selected>Show available tables</option>
            @foreach ($tables as $t)
                <option value="{{$t->tableID}}">Seats: {{$t->seatCount}}</option>
            @endforeach
        </select><br><br>
        <button>Submit</button>

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
    </form>
</body>
</html>