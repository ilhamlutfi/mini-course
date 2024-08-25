@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">Total Course</div>
                                    <div class="card-body">{{ $totalCourse }}</div>
                                    <div class="card-footer">
                                        <a href="{{ route('admin.courses.index') }}" class="btn btn-primary btn-sm float-end">View Course</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">Total Mentor</div>
                                    <div class="card-body">{{ $totalMentor }}</div>
                                    <div class="card-footer">
                                        <a href="#" class="btn btn-primary btn-sm float-end">View Mentor</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">Total Mentee</div>
                                    <div class="card-body">{{ $totalMentee }}</div>
                                    <div class="card-footer">
                                        <a href="#" class="btn btn-primary btn-sm float-end">View Mentee</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="card mb-4">
                                    <div class="card-header">Total Payment Pending</div>
                                    <div class="card-body">{{ $paymentPending }}</div>
                                    <div class="card-footer">
                                        <a href="#" class="btn btn-primary btn-sm float-end">View Payment</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
