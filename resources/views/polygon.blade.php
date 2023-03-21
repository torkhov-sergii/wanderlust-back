@extends('layouts.front')

@section('title', 'Wanderlust')

@section('content')

    <h3>{{ $polygon->title }}</h3>

    <form>
        minRating <input type="text" name="min_rating" value="{{ $minRating }}">

        <div>
            @foreach($types as $key => $type)
                <input id="type_{{ $key }}" type="checkbox" name="type[]" value="{{ $key }}" {{ is_array($selectedTypes) && array_search($key, $selectedTypes) !== false ? 'checked' : '' }}>
                <label for="type_{{ $key }}">{{ $key }}</label>
            @endforeach
        </div>

        <button type="submit">Show</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Rating</th>
            <th>Reviews</th>
            <th>Types</th>
            <th>Polygon radius</th>
            <th>Polygon type</th>
            <th>Polygon depth</th>
        </tr>

        @foreach($places as $place)
            <tr>
                <td>{{ $place->id }}</td>
                <td><a href="https://www.google.com/maps/place/?q=place_id:{{ $place->place_id }}" target="_blank">{{ $place->title }}</a></td>
                <td>{{ $place->rating }}</td>
                <td>{{ $place->ratings_total }}</td>
                <td>{{ implode(', ', $place->getTypes()) }}</td>
                <td>{{ $place->polygon->radius }}</td>
                <td>{{ isset($place->polygon_type) ? $place->polygon_type->title : '' }}</td>
                <td>{{ $place->polygon->depth }}</td>
            </tr>
        @endforeach
    </table>

@endsection
