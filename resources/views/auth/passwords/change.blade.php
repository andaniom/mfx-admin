@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="card">
        <div class="card-header">{{ __('Change Password') }}</div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.updated') }}">
                @csrf
{{--                <input type="hidden" name="token" value="{{ csrf_token() }}">--}}
{{--                <input type="hidden" name="email" value="{{ auth()->user()->email }}">--}}
                <div class="form-group row">
                    <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

                    <div class="col-md-6 input-group">
                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#current_password"><i class="far fa-eye"></i></button>
                        </div>

                        @error('current_password')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                    <div class="col-md-6 input-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password"><i class="far fa-eye"></i></button>
                        </div>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>

                    <div class="col-md-6 input-group">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password_confirmation"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Change Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.toggle-password').click(function () {
            var target = $($(this).data('target'));

            if (target.attr('type') == 'password') {
                target.attr('type', 'text');
                $(this).html('<i class="far fa-eye-slash"></i>');
            } else {
                target.attr('type', 'password');
                $(this).html('<i class="far fa-eye"></i>');
            }
        });
    </script>
@endpush
