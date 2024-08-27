<?php

namespace App\Http\Controllers\Back;

use App\Models\Payment;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('access:owner')->only('destroy', 'approvedCourse');
    }

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
            })->where('mentee_id', auth()->user()->id)->latest()->paginate(10);
        }

        return view('back.payment.index', [
            'payments' => $payments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function paymentCourse(string $chart_id)
    {
        $course = UserCourse::with('mentee:id,name', 'course:id,title,description,price')
        ->where('id', $chart_id)
        ->firstOrFail();

        return view('back.payment.create', [
            'course' => $course
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $coursePay = UserCourse::findOrFail($request->chart_id);

        Payment::create([
            'mentee_id' => $coursePay->mentee_id,
            'course_id' => $coursePay->course_id,
            'amount' => $coursePay->course->price,
            'status' => 'pending',
            'paid_at' => date('Y-m-d H:i:s', time()),
            'approved_at' => null
        ]);

        $coursePay->update([
            'status' => 'paid'
        ]);

        return redirect()->route('lms.payments.index')->with('success', 'Payment course successfully');
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

        $userCourse = UserCourse::where('mentee_id', $payment->mentee_id)
        ->where('course_id', $payment->course_id)
        ->first();
        $userCourse->update([
            'approved_at' => date('Y-m-d H:i:s', time())
        ]);

        return redirect()->route('lms.payments.index')->with('success', 'Course approved successfully');
    }
}
