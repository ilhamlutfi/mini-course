@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Mentee</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <span><b>Edit mentee failed</b></span>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('lms.mentees.update', $mentee->id) }}" method="post" id="create">
                            @method('PUT')
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $mentee->name) }}">
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    value="{{ old('username', $mentee->username) }}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', $mentee->email) }}">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="{{ old('password') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="password_conf" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_conf" id="password_conf"
                                            value="{{ old('password_conf') }}">
                                    </div>
                                </div>

                                <small>(Leave password blank if you don't want to change)</small>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer">
                        <button type="submit" form="create" class="btn btn-primary ms-1 float-end">Update</button>
                        <a href="{{ route('lms.mentees.index') }}" class="btn btn-secondary float-end">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
