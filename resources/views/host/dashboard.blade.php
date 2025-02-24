<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Custom Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">



    <title>Vito Host Dashboard</title>
</head>
<body>  
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand fs-3" href="#" style="font-family: 'Permanent Marker', sans-serif; color: #e63a0f;">Vito Wood Fired Pizza</a>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            {{-- navbar content goes here --}}
          </ul>
          

          <ul class="dropdown pt-2">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Ren Renners
              </a>
              <ul class="dropdown-menu dropdown-menu-sm-end">
                <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>                
              </ul>
            </ul>            
        </div>
    </nav>


    <div class="container mx-auto m-5">
        <ul class="nav nav-tabs" id="contentTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="table-tab" data-bs-toggle='tab' data-bs-target="#tables" type="button">
                    Tables
                </button>
            </li>   
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reservation-tab" data-bs-toggle='tab' data-bs-target="#reservations" type="button">
                    Reservations
                </button>
            </li>
        </ul>
        <div class="tab-content" id="tabContent">
            <div class="tab-pane fade show active" id="tables" role="tabpanel">
                <div id="table-list" class="mt-3">                    
                    {{-- <h3>Tables List</h3> --}}
                    <table border="1" class="datatable table table-bordered">
                        <thead>
                            <tr>                                
                                <th class="text-center">Seat Count</th>
                                <th class="text-center">Availability</th>
                                <th class="text-center"><form method="GET" action="{{route('dinetable.create')}}">
                                    Actions: 
                                    <button class="btn p-0 bg-transparent border-0 ms-2" type="submit">                            
                                        <i class="bi bi-plus-square"></i>
                                    </button>
                                </form></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dineTable as $t)
                                <tr>
                                    <td class="text-center">{{$t->seatCount}}</td>
                                    <td class="text-center">{{$t->availability}}</td>
                                    <td class="d-flex align-items-center justify-content-center">
                                        <a class="me-2" href="{{route('dinetable.edit', $t->tableID)}}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{route('dinetable.delete', $t->tableID)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn p-0 bg-transparent border-0" type="submit"><i class="bi bi-trash text-danger"></i></button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="reservations" role="tabpanel">
                <div id="reservation-list" class="mt-3">
                    {{-- <h3>Reservation List</h3> --}}
                    <table border="1" class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th class='text-center'>Customer</th>
                                <th class='text-center'>Date</th>
                                <th class='text-center'>Start Time</th>                                        
                                <th class='text-center'>End Time</th>
                                <th class='text-center'>                                    
                                    <form action="{{route('reservation.create')}}" method="GET">
                                        @csrf
                                        Actions: 
                                        <button type="submit" class="btn bg-transparent p-0 border-0"><i class="bi bi-plus-square ms-2"></i></button>
                                    </form>
                                </th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $r)
                                <tr>
                                    <td class='text-center'>{{$r->customer->firstName ?? 'Not'}} {{$r->customer->lastName ?? 'Found'}}</td>
                                    <td class='text-center'>{{$r->reserveDate}}</td>
                                    <td class='text-center'>{{$r->startTime}}</td>
                                    <td class='text-center'>{{$r->endTime}}</td>
                                    <td class='d-flex justify-content-center align-items-center'>
                                        <a href="{{route('reservation.edit', $r->resID)}}"><i class="bi bi-pencil me-2"></i></a>
                                        <form action="{{route('reservation.delete', $r->resID)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn bg-transparent border-0 p-0"><i class="bi bi-trash text-danger"></i></button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>   
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="pageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Title here</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>



    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>    
         
    {{-- Initializing the DataTables --}}
    <script>
        $(document).ready(function() {            
            $('.datatable').DataTable({
                responsive:true
            });
        });
    </script>
    
</body>
</html>