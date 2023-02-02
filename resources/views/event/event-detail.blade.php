@extends('layouts.app')

@section('title', 'Event')

@section('content')
    {{ Breadcrumbs::render('event-view', $event) }}
    <div class="media-container">
        <div class="media-renderer d-flex justify-content-center">
           {{-- <div class="bg-image" style="background-image: {{ url('storage/events/'.$event->photo) }}">{{ url('storage/events/'.$event->photo) }}</div>--}}
            <img class="img-render img-fluid" src="{{ url(env("STORAGE_URL", "storage/").'events/'.$event->photo) }}">
{{--            <img class="img-fluid" src="{{ url('storage/events/'.$event->photo) }}">--}}
        </div>
        <div class="mt-5">
            <h4>{{$event->name}}</h4>
            <p>{{$event->date}}</p>
            {!!$event->content!!}
        </div>
    </div>
@endsection
