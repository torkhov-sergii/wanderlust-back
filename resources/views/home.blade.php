@extends('layouts.front')

@section('title', 'Wanderlust')

@section('content')

    @if(isset($polygons))
        <h3>Polygons</h3>
        @foreach($polygons as $polygon)
            <div>
                <a href="/polygon/{{ $polygon->id }}/">{{ $polygon->title }}</a>
            </div>
        @endforeach
    @endif



@endsection
