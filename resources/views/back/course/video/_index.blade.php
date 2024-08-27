<div class="col-md-8 mt-5">
    <div class="card">
        <div class="card-header">
            Course Video

            @if (auth()->user()->role != 'mentee')
                <a href="{{ route('lms.videos.create_video', $course->id) }}" class="btn btn-sm btn-primary float-end">Add
                    Video</a>
            @endif
        </div>

        <div class="card-body">
            @if ($videos->count() > 0)
                @foreach ($videos as $video)
                    <div class="row shadow-sm">
                        <div class="col-lg-6">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item"
                                    src="https://www.youtube.com/embed/{{ $video->url }}" allowfullscreen></iframe>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <h5 class="mt-3">{{ $video->title }}</h5>
                            <p class="text-muted">{{ $video->description }}</p>

                            <a href="{{ route('lms.videos.show', $video->id) }}"
                                class="btn btn-sm btn-secondary float-end">View</a>
                        </div>
                    </div>
                @endforeach
            @else
                <h5 class="text-center">
                    @if (auth()->user()->role != 'mentee')
                        No video found please, add video
                    @else
                        No video waiting payment/approved
                    @endif
                </h5>
            @endif
        </div>
    </div>
</div>
