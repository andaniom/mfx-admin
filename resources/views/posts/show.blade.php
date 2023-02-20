@extends('layouts.app')

@section('title', 'Post')

@section('content')
    {{ Breadcrumbs::render('posts-view', $post) }}
    <div class="media-container">
        <div class="media-renderer d-flex justify-content-center">
            <img class="img-render img-fluid" src="{{ url(env("STORAGE_URL", "storage/").'posts/'.$post->photo) }}" alt="">
        </div>
        <div class="mt-5">
            <h4>{{$post->title}}</h4>
            <p>{{$post->date}}</p>
            {!!$post->content!!}
        </div>
    </div>
@endsection
