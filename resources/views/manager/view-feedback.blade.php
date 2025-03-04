@extends('layouts.manager')
@section('title', 'Feedback')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Customer Feedback</h2>
        <div class="table-responsive">
            <table class="datatable table table-bordered table-striped align-middle" style="table-layout: fixed;">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="text-center">Customer Name</th>                                                
                        <th class="text-center">Feedback</th>
                        <th class="text-center">Date Submitted</th>                        
                        <th class="text-center">Directed to</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($feed as $f)
                        <tr>
                            <td class="text-center">{{$f['customer']->firstName.' '.$f['customer']->lastName}}</td>
                            <td class="text-center" style="max-height: 6rem; overflow-y: auto; word-wrap: break-word;">{{$f['feedback']->description}}</td>
                            <td class="text-center">{{$f['feedback']->dateSubmitted}}</td>
                            <td class="text-center">{{$f['staff']->firstName.' '.$f['staff']->lastName}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>  
@endsection


@push('scripts')
    
@endpush