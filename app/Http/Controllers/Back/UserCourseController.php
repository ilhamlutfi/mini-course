<?php

namespace App\Http\Controllers\Back;

use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCourseController extends Controller
{
    public function __construct()
    {
       $this->middleware('access:owner,mentee')->only('chart');
       $this->middleware('access:owner')->only('destroy');
    }

    public function buy(Request $request, $course_id)
    {
        // get user
        $user = auth()->user();

        // get course
        $course = Course::findOrFail($course_id);

        // check if user already has this course
        $existing = UserCourse::where('mentee_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You already have this course');
        }

        // create user course
        UserCourse::create([
            'mentee_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'approved_at' => null
        ]);

        return redirect()->route('lms.charts', $user->id)->with('success', 'Adding course to cart successfully');
    }

    public function chart(string $user_id)
    {
        $courses = UserCourse::with('course:id,title', 'mentee:id,name')
            ->where('status', 'pending')
            ->where('mentee_id', $user_id)->get();

        return view('back.course.chart.index', [
            'courses' => $courses
        ]);
    }

    public function destroy(string $id)
    {
        UserCourse::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Course deleted successfully');
    }
}
