@extends('layouts.front')

@section('title', 'Wanderlust')

@section('content')

    <div class="circles__page">
        <h3>Polygons Circles</h3>

        <script>
            window.markers = [
                @foreach($polygons as $polygon)
                {
                    position: { lat: {{ $polygon->lat }}, lng: {{ $polygon->lon }} },
                    radius: {{ $polygon->radius }},
                    depth: {{ $polygon->depth }},
                },
                @endforeach
            ];
        </script>
        <div id="map_circles"></div>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.key') }}&callback=initMap"></script>

    </div>

@endsection
