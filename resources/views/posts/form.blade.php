@extends('layouts.app')

@section('scripts')
    <x-head.tinymce-config/>
@endsection

@section('title', 'Post')

@section('content')
    @if(isset($post))
        {{ Breadcrumbs::render('posts-edit', $post) }}
    @else
        {{ Breadcrumbs::render('posts-create' ) }}
    @endif
    <div class="card shadow mb-4">
        <div class="card-header ">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h6>
        </div>
        <div class="card-body">
            <form action="{{  isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
                  enctype="multipart/form-data">
                @if(isset($post))
                    @method('PATCH')
                @endif
                @csrf
                <div class="form-group">
                    <label for="nameInput">Title</label>
                    <input name="title" type="text" class="form-control" id="titleInput"
                           aria-describedby="titleHelp" placeholder="Enter Title Post"
                           value="{{ isset($post) ? $post->title : '' }}" required>
                </div>
                <div class="form-group">
                    <label for="nameInput">Author</label>
                    <input name="author" type="text" class="form-control" id="authorInput"
                           aria-describedby="authorHelp" placeholder="Enter Author Post"
                           value="{{ isset($post) ? $post->author : '' }}" required>
                </div>
                <div class="form-group">
                    <label for="descInput">Description</label>
                    <input name="description" type="text" class="form-control" id="descInput"
                           placeholder="Description"
                           value="{{ isset($post) ? $post->description : '' }}" required>
                </div>
                <div class="form-group">
                    @include('components.upload.upload-image',['label'=>'Photo', 'multiple'=>false])
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea id="tinyMce" name="contentTiny">{{ isset($post) ? $post->content : '' }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
