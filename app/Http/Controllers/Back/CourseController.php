<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('access:owner')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'owner') {
            $courses = Course::with('user:id,name')->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%');
            })->latest()->paginate(6);
        } elseif (auth()->user()->role == 'mentor') {
            $courses = Course::with('user:id,name')->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%');
            })->where('mentor_id', auth()->user()->id)->latest()->paginate(6);
        }
        // else {
        //     $courses = UserCourse::where('user_id', auth()->user()->id)->latest()->paginate(6);
        // }

        return view('back.course.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.course.create', [
            'mentors' => User::whereRole('mentor')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:128|unique:courses,title',
            'description' => 'required|max:128',
            'price' => 'required|numeric',
            'mentor_id' => 'required',
        ]);

        if (!$data) {
            return redirect()->back()->with('error', 'Course not created');
        }

        Course::create($data);

        return redirect()->route('lms.courses.index')->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with('user:id,name')->findOrFail($id);

        $this->authorize('view', $course);

        $videos = CourseVideo::with('course:id,title')
        ->where('course_id', $id)
        ->paginate(10);

        return view('back.course.show', [
            'course' => $course,
            'videos' => $videos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::with('user:id,name')->findOrFail($id);

        $this->authorize('view', $course);

        return view('back.course.edit', [
            'mentors' => User::whereRole('mentor')->get(),
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|max:128|unique:courses,title,'. $id,
            'description' => 'required|max:128',
            'price' => 'required|numeric',
            'mentor_id' => 'required',
        ]);

        Course::findOrFail($id)->update($data);

        return redirect()->route('lms.courses.show', $id)->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::findOrFail($id)->delete();

        return redirect()->route('lms.courses.index')->with('success', 'Course deleted successfully');
    }
}
