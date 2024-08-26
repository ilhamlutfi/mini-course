<?php

namespace App\Http\Controllers\Back;

use App\Models\Course;
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

    public function createVideo(string $id)
    {
        $course = Course::select('id', 'title')->findOrFail($id);

        return view('back.course.video.create', [
            'course' => $course
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255|unique:course_videos,title',
            'url'           => 'required|string|max:255|unique:course_videos,url',
            'description'   => 'required|string',
            'course_id'     => 'required|exists:courses,id',
        ]);

        CourseVideo::create($data);

        return redirect()->route('lms.courses.show', $data['course_id'])->with('success', 'Video created successfully!');
    }

    public function edit(string $id)
    {
        $video = CourseVideo::with('course:id,title')->findOrFail($id);

        return view('back.course.video.edit', [
            'video' => $video
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255|unique:course_videos,title,'. $id,
            'url'           => 'required|string|max:255|unique:course_videos,url,'. $id,
            'description'   => 'required|string',
            'course_id'     => 'required|exists:courses,id',
        ]);

        CourseVideo::findOrFail($id)->update($data);

        return redirect()->route('lms.courses.show', $data['course_id'])->with('success', 'Video updated successfully!');
    }

    public function destroy(string $id)
    {
        $video = CourseVideo::findOrFail($id);

        $course_id = $video->course_id;

        $video->delete();

        return redirect()->route('lms.courses.show', $course_id)->with('success', 'Video deleted successfully!');
    }
}
