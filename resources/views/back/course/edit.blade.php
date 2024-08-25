@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Course</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <span><b>Edit course failed</b></span>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('lms.courses.update', $course->id) }}" method="post" id="update">
                            @method('PUT')
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="{{ old('title', $course->title) }}">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{ old('description', $course->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" id="price"
                                    value="{{ old('price', $course->price) }}">
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Mentor</label>
                                <select name="mentor_id" id="mentor_id" class="form-select">
                                    <option value="" hidden>Select Mentor</option>
                                    @foreach ($mentors as $mentor)
                                        <option value="{{ $mentor->id }}" {{ old('mentor_id', $mentor->id) == $course->mentor_id ? 'selected' : '' }}>{{ $mentor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <button type="submit" form="update" class="btn btn-primary ms-1 float-end">Update</button>
                        <a href="{{ route('lms.courses.index') }}" class="btn btn-secondary float-end">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
