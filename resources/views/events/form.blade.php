@extends('layouts.app')

@section('title', 'Event')

@section('content')
    @if(isset($event))
        {{ Breadcrumbs::render('events-edit', $event) }}
    @else
        {{ Breadcrumbs::render('events-create' ) }}
    @endif
    <div class="card shadow mb-4">
        <div class="card-header ">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
            <div class="card-body">
                <form action="{{  isset($event) ? route('events.update', $event->id) : route('events.store') }}"
                      method="POST" enctype="multipart/form-data">
                    @if(isset($event))
                        @method('PATCH')
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="nameInput">Name</label>
                        <input name="name" type="text" class="form-control" id="nameInput"
                               aria-describedby="nameHelp" placeholder="Enter Name Event"
                               value="{{ isset($event) ? $event->name : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="dateInput">Date</label>
                        <input name="date" type="datetime-local" class="form-control" id="dateInput"
                               placeholder="Enter Date Event"
                               value="{{ isset($event) ? $event->date : '' }}" required>
                    </div>
                    <div class=" form-group">
                        <label for="descInput">Description</label>
                        <input name="description" type="text" class="form-control" id="descInput"
                               placeholder="Description"
                               value="{{ isset($event) ? $event->description : '' }}" required>
                    </div>
                    <div class="form-group">
                        @include('components.upload.upload-image',['label'=>'Photo', 'multiple'=>false])
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea id="tinyMce" name="contentTiny">{{ isset($event) ? $event->content : '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
@endsection
