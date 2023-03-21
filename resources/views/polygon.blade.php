@extends('layouts.front')

@section('title', 'Wanderlust')

@section('content')

    <div class="polygon__page">
        <h3>{{ $polygon->title }}</h3>

        <form>
            <input type="radio" name="style" id="style_list" value="list" {{ ($selectedStyle == 'list') ? 'checked' : '' }}> <label for="style_list">list</label>
            <input type="radio" name="style" id="style_map" value="map" {{ ($selectedStyle == 'map') ? 'checked' : '' }}> <label for="style_map">map</label>

            MinReviews <input type="text" name="min_rating" value="{{ $minRating }}">

            <div>
                @foreach($types as $key => $type)
                    <input id="type_{{ $key }}" type="checkbox" name="type[]" value="{{ $key }}" {{ is_array($selectedTypes) && array_search($key, $selectedTypes) !== false ? 'checked' : '' }}>
                    <label for="type_{{ $key }}">{{ $key }}</label>
                @endforeach
            </div>

            <button type="submit">Show</button>
        </form>

        @if($selectedStyle == 'map')
            <script>
                window.markers = [
                        @foreach($places as $place)
                    {
                        position: { lat: {{ $place->lat }}, lng: {{ $place->lon }} },
                        title: "{{ $place->title." (".$place->ratings_total.")" }}",
                        url: "https://www.google.com/maps/place/?q=place_id:{{ $place->place_id }}",
                        user_rating: "{{ $place->user_rating }}",
                    },
                    @endforeach
                ];
            </script>
            <div id="map"></div>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3xO6BVrYHeD-sgkUbpEU6UjtWEWpYEdw&callback=initMap"></script>
        @endif

        @if($selectedStyle == 'list')
            <table class="polygon__table">
                <tr>
                    <th>ID</th>
                    <th>User rating</th>
                    <th>Title</th>
                    <th>Rating</th>
                    <th>Reviews</th>
                    <th>Types</th>
                    <th>Polygon radius</th>
                    <th>Polygon type</th>
                    <th>Polygon depth</th>
                </tr>

                @foreach($places as $place)
                    <tr class="color_{{ $place->user_rating }}">
                        <td>{{ $place->id }}</td>
                        <td>
                            <select name="user_rating" class="js_user_rating" data-place_id="{{ $place->id }}" style="width: 100%; text-align: center">
                                <option value=""></option>
                                <option value="5" {{ ($place->user_rating == 5) ? 'selected' : '' }}>5</option>
                                <option value="4" {{ ($place->user_rating == 4) ? 'selected' : '' }}>4</option>
                                <option value="3" {{ ($place->user_rating == 3) ? 'selected' : '' }}>3</option>
                                <option value="2" {{ ($place->user_rating == 2) ? 'selected' : '' }}>2</option>
                                <option value="1" {{ ($place->user_rating == 1) ? 'selected' : '' }}>1</option>
                            </select>
                        </td>
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
        @endif
    </div>

@endsection
