<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'owner') {
            $courses = Course::with('user:id,name,role')->when(request('search'), function ($query) {
                $query->where('title', 'like', '%' . request('search') . '%');
            })->latest()->paginate(6);
        } elseif (auth()->user()->role == 'mentor') {
            $courses = Course::with('user:id,name,role')->when(request('search'), function ($query) {
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
            'title' => 'required|max:128',
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
        return view('back.course.show', [
            'course' => Course::with('user:id,name,role')->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
