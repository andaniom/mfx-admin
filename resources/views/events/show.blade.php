@extends('layouts.app')

@section('title', 'Event')

@section('content')
    {{ Breadcrumbs::render('events-view', $event) }}
    <div class="media-container">
        <div class="media-renderer d-flex justify-content-center">
           {{-- <div class="bg-image" style="background-image: {{ url('storage/events/'.$events->photo) }}">{{ url('storage/events/'.$events->photo) }}</div>--}}
            <img class="img-render img-fluid" src="{{ url(env("STORAGE_URL", "storage/").'events/'.$event->photo[0]) }}">
{{--            <img class="img-fluid" src="{{ url('storage/events/'.$events->photo) }}">--}}
        </div>
        <div class="mt-5">
            <h4>{{$event->name}}</h4>
            <p>{{$event->date}}</p>
            {!!$event->content!!}
        </div>
    </div>
@endsection
