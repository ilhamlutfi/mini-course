@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Video</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <span><b>Edit video failed</b></span>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('lms.videos.update', $video->id) }}" method="post" id="create">
                            @method('PUT')
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="{{ old('title', $video->title) }}">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{ old('description', $video->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Url Video <small>(https://www.youtube.com/watch?v=(copy))</small></label>
                                <input type="text" name="url" id="url" class="form-control" value="{{ old('url', $video->url) }}">
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Course : {{ $video->course->title }}</label>
                                <input type="hidden" name="course_id" class="form-control" value="{{ $video->course->id }}" readonly>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer">
                        <button type="submit" form="create" class="btn btn-primary ms-1 float-end">Update</button>
                        <a href="{{ route('lms.courses.show', $video->course->id) }}" class="btn btn-secondary float-end">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
