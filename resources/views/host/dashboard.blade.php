<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>    
    <h1>Host Dashboard</h1>
    
    <div id="table-list">
        <h3>Tables List</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Seat Count</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dineTable as $t)
                    <tr>
                        <td>{{$t->seatCount}}</td>
                        <td>{{$t->availability}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <br>


    <div id="reservation-list">
        <h3>Reservation List</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Time</th>                                        
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $r)
                    <tr>
                        <td>{{$r->customer->firstName ?? 'Not'}} {{$r->customer->lastName ?? 'Found'}}</td>
                        <td>{{$r->reserveDate}}</td>
                        <td>{{$r->reserveTime}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    <footer>
        <form method="GET" action="{{route('logout')}}">
            <button type="submit">Logout</button>
        </form>

    </footer>
</body>
</html>