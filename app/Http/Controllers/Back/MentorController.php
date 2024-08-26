<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'owner') {
            $mentors = User::select(['id', 'name', 'username', 'email', 'created_at'])
            ->when(request('search'), function ($query) {
                return $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->whereRole('mentor')
            ->latest()
            ->paginate(10);
        } else {
            $mentors = User::select(['id', 'name', 'username', 'email', 'created_at'])
            ->whereRole('mentor')
            ->where('id', auth()->user()->id)
            ->latest()
            ->paginate(10);
        }

        return view('back.mentor.index', [
            'mentors' => $mentors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.mentor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required',
            'username'      => 'required|unique:users,username',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required',
            'password_conf' => 'required|same:password',
        ]);

        $data['role'] = 'mentor';
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('lms.mentors.index')->with('success', 'Mentor created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('back.mentor.edit', [
            'mentor' => User::whereRole('mentor')->findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'          => 'required',
            'username'      => 'required|unique:users,username,'. $id,
            'email'         => 'required|email|unique:users,email,'. $id,
        ]);

        $data['role'] = 'mentor';

        if ($request->password) {
            $data = $request->validate([
                'password'      => 'nullable',
                'password_conf' => 'required_with:password|same:password',
            ]);
            $data['password'] = bcrypt($data['password']);
        }

        User::findOrFail($id)->update($data);

        return redirect()->route('lms.mentors.index')->with('success', 'Mentor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('lms.mentors.index')->with('success', 'Mentor deleted successfully');
    }
}
