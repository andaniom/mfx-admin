@extends('layouts.app')

@section('title', 'Post')

@section('content')
    {{ Breadcrumbs::render('post-create') }}
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nameInput">Title</label>
            <input name="title" type="text" class="form-control" id="titleInput"
                   aria-describedby="titleHelp" placeholder="Enter Title Post" required>
        </div>
        <div class="form-group">
            <label for="nameInput">Author</label>
            <input name="author" type="text" class="form-control" id="authorInput"
                   aria-describedby="authorHelp" placeholder="Enter Author Post" required>
        </div>
        <div class="form-group">
            <label for="descInput">Description</label>
            <input name="description" type="text" class="form-control" id="descInput"
                   placeholder="Description" required>
        </div>
        <div class="form-group">
            <label for="photoInput">Photo</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Upload Photo</span>
                </div>
                <div class="custom-file">
                    <input name="photo" type="file" class="custom-file-input" id="photoInput"
                           accept="image/*" required>
                    <label class="custom-file-label" for="photoInput">Choose file</label>
                </div>
            </div>
            <div id="divImageMediaPreview"></div>
            <div id="myModal" class="modal modal-img">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01" alt="">
                <div id="caption"></div>
            </div>
        </div>
        <div class="form-group">
            <label>Content</label>
            <x-forms.tinymce-editor/>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
