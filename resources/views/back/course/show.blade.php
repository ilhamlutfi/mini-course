@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Course Detail</div>

                    <div class="card-body">
                        {{-- alert --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

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
                        @if (auth()->user()->role != 'mentee')
                            @if (auth()->user()->role == 'owner')
                                <form action="{{ route('lms.courses.destroy', $course->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger ms-1 float-end">Delete</button>
                                </form>
                            @endif

                            <a href="{{ route('lms.courses.edit', $course->id) }}"
                                class="btn btn-success ms-1 float-end">Edit</a>
                        @endif

                        <a href="{{ route('lms.courses.index') }}" class="btn btn-secondary float-start">Back</a>
                    </div>
                </div>
            </div>

            {{-- course video --}}
            @include('back.course.video._index', ['course_id' => $course->id])
        </div>
    </div>
@endsection
