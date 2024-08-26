<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CoursePolicy
{
    use AuthorizesRequests;

    public function view(User $user, Course $course): Response
    {
        return $user->id === $course->mentor_id
            ? Response::allow()
            : Response::deny('You are not the owner of this course.');
    }
}
