<?php

namespace App\Http\Controllers\Back;

use App\Models\CourseVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseVideoController extends Controller
{
    public function show(string $id)
    {
        $video = CourseVideo::findOrFail($id);

        return view('back.course.video.show', [
            'video' => $video,
            'playlists' => CourseVideo::where('course_id', $video->course_id)->get()
        ]);
    }
}
