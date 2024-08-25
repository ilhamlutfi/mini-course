@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Course Detail</div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Title</th>
                                <td>{{ $course->title }}</td>
                            </tr>

                            <tr>
                                <th>Description</th>
                                <td>{{ $course->description }}</td>
                            </tr>

                            <tr>
                                <th>Price</th>
                                <td>Rp. {{ number_format($course->price, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <th>Mentor</th>
                                <td>{{ $course->user->name }}</td>
                            </tr>

                            <tr>
                                <th>Created At</th>
                                <td>{{ $course->created_at }}</td>
                            </tr>

                            <tr>
                                <th>Updated At</th>
                                <td>{{ $course->created_at }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="card-footer">
                        <a href="{{ url()->previous() }}" class="btn btn-success ms-1 float-end">Edit</a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary float-end">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
