@extends('layouts.app')

@section('title', 'Error')

@section('content')
    <div class="w-full h-50">
        <div class="d-flex justify-content-center mt-32">
            <div class="px-4 text-lg text-gray-500">
                {{$errorCode}}
            </div>
            <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                {{$message}}
            </div>
        </div>
    </div>
@endsection
