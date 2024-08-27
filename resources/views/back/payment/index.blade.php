@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Payments List</div>

                    <div class="card-body">
                        {{-- alert --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('lms.payments.index') }}" method="get">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Search Payment"
                                    value="{{ request('search') }}">

                                <button class="btn btn-secondary" type="submit">Search</button>
                            </div>
                        </form>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mentee</th>
                                    <th>Course</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Is Paid</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration + ($payments->firstItem() - 1) }}</td>
                                        <td>{{ $payment->user->name }}</td>
                                        <td>{{ $payment->course->title }}</td>
                                        <td>Rp. {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($payment->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($payment->status == 'pending')
                                                <span class="badge bg-danger">Pending</span>
                                            @else
                                                <span class="badge bg-warning">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($payment->paid_at)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-danger">No</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->created_at }}</td>
                                        <td width="10%">
                                            <div class="w-full">
                                                <a href="{{ route('lms.payments.show', $payment->id) }}"
                                                    class="btn btn-primary btn-sm me-1 w-100">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No data available, please buy course first <a href="{{ route('lms.courses.index') }}">courses list</a></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
