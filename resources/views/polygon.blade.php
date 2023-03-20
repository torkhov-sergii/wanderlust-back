@extends('layouts.front')

@section('title', 'Wanderlust')

@section('content')

    <h3>{{ $polygon->title }}</h3>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Rating</th>
            <th>Reviews</th>
            <th>Types</th>
            <th>Polygon radius</th>
            <th>Polygon type</th>
        </tr>

        @foreach($places as $place)
            <tr>
                <td>{{ $place->id }}</td>
                <td><a href="https://www.google.com/maps/place/?q=place_id:{{ $place->place_id }}" target="_blank">{{ $place->title }}</a></td>
                <td>{{ $place->rating }}</td>
                <td>{{ $place->ratings_total }}</td>
                <td>{{ implode(', ', $place->types) }}</td>
                <td>{{ $place->polygon->radius }}</td>
                <td>{{ isset($place->polygon_type) ? $place->polygon_type->title : '' }}</td>
            </tr>
        @endforeach
    </table>

@endsection
