<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'owner') {
            $payments = Payment::with('course:id,title', 'user:id,name')->when(request('search'), function ($query) {
                $query->whereHas('course', function ($query) {
                    $query->where('title', 'like', '%' . request('search') . '%');
                });
            })->latest()->paginate(10);
        } else {
            $payments = Payment::with('course:id,title', 'user:id,name')->when(request('search'), function ($query) {
                $query->whereHas('course', function ($query) {
                    $query->where('title', 'like', '%' . request('search') . '%');
                });
            })->where('user_id', auth()->user()->id)->latest()->paginate(10);
        }

        return view('back.payment.index', [
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('back.payment.show', [
            'payment' => Payment::with('course:id,title', 'user:id,name')->findOrFail($id)
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
        Payment::findOrFail($id)->delete();

        return redirect()->route('lms.payments.index')->with('success', 'Payment deleted successfully');
    }

    public function approvedCourse(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => 'approved',
            'approved_at' => date('Y-m-d H:i:s', time())
        ]);

        return redirect()->route('lms.payments.index')->with('success', 'Course approved successfully');
    }
}
