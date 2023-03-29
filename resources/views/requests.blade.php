@extends('layouts.front')

@section('title', 'Scan')

@section('content')

    <h1>
        Radius: {{ $radius }}
    </h1>

    <table class="polygon__table">
        <tr>
            <th>Iteration</th>
            <th>Radius</th>
            <th>Requests</th>
            <th>Total Requests</th>
        </tr>

        @foreach($requests as $key => $request)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $request['radius'] }}</td>
                <td>{{ $request['requests'] }}</td>
                <td>{{ $request['total_requests'] }}</td>
            </tr>
        @endforeach
    </table>

@endsection
