@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Mentees List

                        <a href="{{ route('lms.mentees.create') }}" class="btn btn-primary btn-sm float-end">Create Mentee</a>
                    </div>

                    <div class="card-body">
                        {{-- alert --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('lms.mentees.index') }}" method="get">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Search Mentee"
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
                                @foreach ($mentees as $mentee)
                                    <tr>
                                        <td>{{ $loop->iteration + ($mentees->firstItem() - 1) }}</td>
                                        <td>{{ $mentee->name }}</td>
                                        <td>{{ $mentee->username }}</td>
                                        <td>{{ $mentee->email }}</td>
                                        <td>{{ $mentee->created_at }}</td>
                                        <td width="10%">
                                            <div class="d-flex">
                                                <a href="{{ route('lms.mentees.edit', $mentee->id) }}"
                                                    class="btn btn-success ms-1 float-end">Edit</a>

                                                <form action="{{ route('lms.mentees.destroy', $mentee->id) }}"
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

                        {{ $mentees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
