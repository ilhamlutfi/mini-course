@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $video->title }}</div>

                    <div class="card-body p-0">
                        <div style="position: relative; padding-top: 56.25%; height: 0; overflow: hidden;">
                            <iframe src="https://www.youtube.com/embed/{{ $video->url }}"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0"
                                allowfullscreen></iframe>
                        </div>
                    </div>

                    <div class="card-footer">
                        @if (auth()->user()->role != 'mentee')
                            <form action="{{ route('lms.videos.destroy', $video->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger ms-1 float-end">Delete</button>
                            </form>

                            <a href="{{ route('lms.videos.edit', $video->id) }}"
                                class="btn btn-success ms-1 float-end">Edit</a>

                            <a href="{{ route('lms.courses.show', $video->course->id) }}" class="btn btn-secondary float-start">Back</a>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Playlist --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ $video->course->title }}</div>

                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($playlists as $playlistVideo)
                            <ul class="list-group mb-2">
                                <li class="list-group-item {{ $playlistVideo->id == $video->id ? 'active' : '' }}">
                                    <a href="{{ route('lms.videos.show', $playlistVideo->id) }}"
                                        class="{{ $playlistVideo->id == $video->id ? 'text-white' : '' }}"
                                        style="text-decoration: none">
                                        {{ $playlistVideo->title }}
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
