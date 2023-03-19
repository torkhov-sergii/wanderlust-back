@extends('layouts.front')

@section('title', 'Wanderlust')

@section('content')

    @if(isset($polygons))
        <h3>Polygons</h3>
        @foreach($polygons as $polygon)
            <a href="/polygon/{{ $polygon->id }}/">{{ $polygon->title }}</a>
        @endforeach
    @endif



@endsection
