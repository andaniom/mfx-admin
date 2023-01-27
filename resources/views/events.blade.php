@extends('layouts.app')

@section('title', 'Event')

@section('content')
    {{--{{ Breadcrumbs::render('event') }}--}}
    <div class="card shadow mb-4">
        <div class="card-header py-3  d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{"Event List"}}</h6>
            <a type="button" class="btn btn-primary" href={{ route('events.create') }}>{{'Add Event'}}</a>
        </div>
{{--        <div class="card-body">--}}
{{--            <div class="table-responsive">--}}
{{--                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>Nama Event</th>--}}
{{--                        <th>Photo</th>--}}
{{--                        <th>Tanggal</th>--}}
{{--                        <th>Description</th>--}}
{{--                        <th>Action</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    @foreach($events as $event)--}}
{{--                        <tbody>--}}
{{--                        <td>{{ $event->name }}</td>--}}
{{--                        <td><img style="width: 100px" src="{{ url('storage/events/'.$event->photo) }}" alt="" title=""/>--}}
{{--                        </td>--}}
{{--                        <td>{{ $event->date }}</td>--}}
{{--                        <td>{{ $event->description }}</td>--}}
{{--                        <td>--}}
{{--                            <a type="button" class="btn btn-primary" href="{{route('events.view', $event->id)}}"><i--}}
{{--                                    class="far fa-eye"></i></a>--}}
{{--                            <a type="button" class="btn btn-success"><i class="fas fa-edit"></i></a>--}}
{{--                            <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete"><i--}}
{{--                                    class="far fa-trash-alt"></i></a>--}}

{{--                            <form action="{{ route('events.delete', $event->id) }}" method="post">--}}
{{--                                @csrf--}}
{{--                                <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog"--}}
{{--                                     aria-labelledby="modalDeleteTitle" aria-hidden="true">--}}
{{--                                    <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--                                        <div class="modal-content">--}}
{{--                                            <div class="modal-header">--}}
{{--                                                <h5 class="modal-title" id="modalDeleteTitle">Delete</h5>--}}
{{--                                                <button type="button" class="close" data-dismiss="modal"--}}
{{--                                                        aria-label="Close">--}}
{{--                                                    <span aria-hidden="true">&times;</span>--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-body">--}}
{{--                                                <p>Are you sure to delete?</p>--}}
{{--                                            </div>--}}
{{--                                            <div class="modal-footer">--}}
{{--                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">--}}
{{--                                                    Cancel--}}
{{--                                                </button>--}}
{{--                                                <button type="submit" class="btn btn-primary">Yes--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </tbody>--}}
{{--                    @endforeach--}}
{{--                </table>--}}
{{--                <div class="d-flex">--}}
{{--                    <br/>--}}
{{--                    Halaman : {{ $events->currentPage() }} <br/>--}}
{{--                    Jumlah Data : {{ $events->total() }} <br/>--}}
{{--                    Data Per Halaman : {{ $events->perPage() }} <br/>--}}
{{--                    {!! $events->links() !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
