@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Payment Detail</div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Mentee</th>
                                <td>{{ $payment->user->name }}</td>
                            </tr>

                            <tr>
                                <th>Course</th>
                                <td>{{ $payment->course->title }}</td>
                            </tr>

                            <tr>
                                <th>Amount</th>
                                <td>Rp. {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($payment->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($payment->status == 'pending')
                                        <span class="badge bg-danger">Pending</span>
                                    @else
                                        <span class="badge bg-warning">Rejected</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Is Paid</th>
                                <td>
                                    @if ($payment->paid_at)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                            </tr>

                            @if ($payment->status == 'approved')
                                <tr>
                                    <th>Approved At</th>
                                    <td>{{ $payment->approved_at }}</td>
                                </tr>
                            @endif

                            @if ($payment->paid_at)
                                <tr>
                                    <th>Paid At</th>
                                    <td>{{ $payment->paid_at }}</td>
                                </tr>
                            @endif

                            <tr>
                                <th>Created At</th>
                                <td>{{ $payment->created_at }}</td>
                            </tr>

                            <tr>
                                <th>Updated At</th>
                                <td>{{ $payment->created_at }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="card-footer">
                        {{-- submit delete button --}}
                        @if (auth()->user()->role == 'owner')
                            <form action="{{ route('lms.payments.destroy', $payment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger ms-1 float-end">Delete</button>
                            </form>

                            @if ($payment->paid_at != null && $payment->status == 'pending')
                                <form action="{{ route('lms.payments.approved', $payment->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    <button type="submit" class="btn btn-success ms-1 float-end">Approved</button>
                                </form>
                            @endif
                        @endif

                        <a href="{{ url()->previous() }}" class="btn btn-secondary float-start">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
