@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Course List

                        @if (auth()->user()->role != 'mentee')
                            <a href="{{ route('lms.courses.create') }}" class="btn btn-primary btn-sm float-end">Create Course</a>
                        @endif
                    </div>


                    <div class="card-body">
                        {{-- alert --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- search  --}}
                        <form action="{{ route('lms.courses.index') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Search Course"
                                    value="{{ request('search') }}">

                                <button class="btn btn-secondary" type="submit">Search</button>
                            </div>
                        </form>

                        <div class="row">
                            @forelse ($courses as $course)
                                <div class="col-lg-4">
                                    <div class="card mb-4">
                                        <div class="card-header">{{ $course->title }}</div>

                                        <div class="card-body">
                                            {{ $course->description }}
                                        </div>

                                        <div class="card-footer">
                                            <p class="float-start">
                                                Mentor: {{ $course->user->name }}
                                            </p>
                                            <a href="{{ route('lms.courses.show', $course->id) }}"
                                                class="btn btn-primary btn-sm float-end">View Course</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-danger">No Course</div>
                            @endforelse

                            {{ $courses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
