@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Chart List
                    </div>

                    <div class="card-body">
                        {{-- alert --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $course->mentee->name }}</td>
                                        <td>{{ $course->course->title }}</td>
                                        <td>{{ $course->status }}</td>
                                        <td>{{ $course->created_at }}</td>
                                        <td width="10%">
                                            <div class="d-flex">
                                                <a href="{{ route('lms.payments.process', $course->id) }}"
                                                    class="btn btn-success ms-1 float-end">Payment</a>

                                                <form action="{{ route('lms.mentees.destroy', $course->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-danger ms-1 float-end">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
