@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    {{ Breadcrumbs::render('settings') }}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Settings"}}</h6>
            <div>
                <a data-toggle="modal" data-target="#settingLocationModal" class="btn btn-primary btn-sm">Add
                    Location</a>
                <a data-toggle="modal" data-target="#settingModal" class="btn btn-primary btn-sm">Add
                    Settings</a>
            </div>
        </div>

        <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingModalLabel">Settings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('settings.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Value:</label>
                                <input type="text" class="form-control" id="value" name="value">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="settingLocationModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingModalLabel">Location Settings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            @csrf
                            <button id="locationBtn" type="button" class="btn btn-primary">Get Current Location</button>
                            <div class="form-group">
                                <label for="name" class="col-form-label">Longitude:</label>
                                <input type="text" class="form-control" id="longitude" name="longitude">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Latitude:</label>
                                <input type="text" class="form-control" id="latitude" name="latitude">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button id="submitLocationBtn" type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th width="3%" colspan="3">Action</th>
                    </tr>
                    </thead>
                    @foreach ($settings as $key => $setting)
                        <tr>
                            <td>{{ $setting->name }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#{{$setting->name}}modal"
                                   class="btn btn-info btn-sm">Edit</a>
                                <div class="modal fade" id="{{$setting->name}}modal" tabindex="-1" role="dialog"
                                     aria-labelledby="editSettingModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editSettingModalLabel">Settings {{$setting->name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post"
                                                      action="{{route('settings.update', $setting->id)}}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Name:</label>
                                                        <input type="text" class="form-control" id="name" name="name"
                                                               value="{{$setting->name}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Value:</label>
                                                        <input type="text" class="form-control" id="value" name="value"
                                                               value="{{$setting->value}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $settings->links('components.pagination.custom') }}
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#locationBtn").click(function (e) {
            getLocation()
                .then(position => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    console.log('Latitude: ' + latitude);
                    console.log('Longitude: ' + longitude);
                    document.getElementById("latitude").value = latitude;
                    document.getElementById("longitude").value = longitude;
                })
                .catch(error => {
                    showError(error)
                });
        })

        $("#submitLocationBtn").click(function (e) {
            $.ajax({
                url: '{{route('settings.store')}}',
                method: 'POST',
                data: {
                    'name': "latitude",
                    'value': document.getElementById("latitude").value
                },
                success: function (response) {
                    $.ajax({
                        url: '{{route('settings.store')}}',
                        method: 'POST',
                        data: {
                            'name': "longitude",
                            'value': document.getElementById("longitude").value
                        },
                        success: function (response) {
                            location.reload();
                        },
                        error: function (response) {
                            console.log(response)
                            // Handle the error response
                        }
                    });
                },
                error: function (response) {
                    console.log(response)
                    // Handle the error response
                }
            });
        })
    </script>
@endsection
