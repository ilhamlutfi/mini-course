@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Mentors List

                        <a href="{{ route('lms.mentors.create') }}" class="btn btn-primary btn-sm float-end">Create Mentor</a>
                    </div>

                    <div class="card-body">
                        {{-- alert --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('lms.mentors.index') }}" method="get">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Search Mentor"
                                    value="{{ request('search') }}">

                                <button class="btn btn-secondary" type="submit">Search</button>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($mentors as $mentor)
                                    <tr>
                                        <td>{{ $loop->iteration + ($mentors->firstItem() - 1) }}</td>
                                        <td>{{ $mentor->name }}</td>
                                        <td>{{ $mentor->username }}</td>
                                        <td>{{ $mentor->email }}</td>
                                        <td>{{ $mentor->created_at }}</td>
                                        <td width="10%">
                                            <div class="d-flex">
                                                @if (auth()->user()->role == 'owner')
                                                    <a href="{{ route('lms.mentors.edit', $mentor->id) }}"
                                                        class="btn btn-success ms-1 float-end">Edit</a>

                                                    <form action="{{ route('lms.mentors.destroy', $mentor->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="btn btn-danger ms-1 float-end">Delete</button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('lms.mentors.edit', $mentor->id) }}"
                                                        class="btn btn-success ms-1 float-end">Edit</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $mentors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
