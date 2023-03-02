@extends('layouts.app')

@section('title', 'User')

@section('content')
    {{ Breadcrumbs::render('users') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Users"}}</h6>
        </div>
        <div class="card-body">
            <div class="container mt-4">
                <form method="post" action="{{ route('profile.update', $user) }}">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input value="{{ $user->name }}"
                               type="text"
                               class="form-control"
                               name="name"
                               placeholder="Name" required>

                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input id="phone_number" type="text" value="{{ $user->phone_number }}"
                               class="form-control phone @error('phone_number') is-invalid @enderror"
                               name="phone_number" {{--value="{{ old('phone_number') }}"--}} required
                               autocomplete="phone_number" autofocus placeholder="+62 000-0000-00000">
                        @if ($errors->has('phone_number'))
                            <span class="text-danger text-left">{{ $errors->first('phone_number') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input value="{{ $user->birth_date }}"
                               type="date"
                               class="form-control"
                               name="birth_date"
                               placeholder="Birth Date" required>

                        @if ($errors->has('birth_date'))
                            <span class="text-danger text-left">{{ $errors->first('birth_date') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update user</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ url('/') }}/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/inputmask.min.js" integrity="sha512-czERuOifK1fy7MssE4JJ7d0Av55NPiU2Ymv4R6F0mOGpyPUb9HkP9DcEeE+Qj9In7hWQHGg0CqH1ELgNBJXqGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#phone_number').mask('+62 000-0000-00000');
    </script>
@endsection
