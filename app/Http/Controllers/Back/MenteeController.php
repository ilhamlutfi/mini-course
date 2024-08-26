<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenteeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'owner') {
            $mentees = User::select(['id', 'name', 'username', 'email', 'created_at'])
            ->when(request('search'), function ($query) {
                return $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->whereRole('mentee')
            ->latest()
            ->paginate(10);
        } else {
            $mentees = User::select(['id', 'name', 'username', 'email', 'created_at'])
            ->whereRole('mentee')
            ->where('id', auth()->user()->id)
            ->latest()
            ->paginate(10);
        }

        return view('back.mentee.index', [
            'mentees' => $mentees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.mentee.create');
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

        $data['role'] = 'mentee';
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('lms.mentees.index')->with('success', 'Mentee created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('back.mentee.edit', [
            'mentee' => User::whereRole('mentee')->findOrFail($id)
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

        $data['role'] = 'mentee';

        if ($request->password) {
            $data = $request->validate([
                'password'      => 'nullable',
                'password_conf' => 'required_with:password|same:password',
            ]);
            $data['password'] = bcrypt($data['password']);
        }

        User::findOrFail($id)->update($data);

        return redirect()->route('lms.mentees.index')->with('success', 'Mentee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('lms.mentees.index')->with('success', 'Mentee deleted successfully');
    }
}
