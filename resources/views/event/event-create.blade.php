@extends('layouts.app')

@section('title', 'Event')

@section('content')
    {{ Breadcrumbs::render('event-create') }}
    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nameInput">Name</label>
            <input name="name" type="text" class="form-control" id="nameInput"
                   aria-describedby="nameHelp" placeholder="Enter Name Event" required>
        </div>
        <div class="form-group">
            <label for="dateInput">Date</label>
            <input name="date" type="datetime-local" class="form-control" id="dateInput"
                   placeholder="Enter Date Event" required>
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
        </div>
        <div class="form-group">
            <label>Content</label>
            <x-forms.tinymce-editor/>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
