@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Payment Detail</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <span><b>Payment course failed</b></span>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- course detail --}}
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Name</th>
                                <td>{{ $course->mentee->name }}</td>
                            </tr>

                            <tr>
                                <th>Course</th>
                                <td>{{ $course->course->title }}</td>
                            </tr>

                            <tr>
                                <th>Description</th>
                                <td>{{ $course->course->description }}</td>
                            </tr>

                            <tr>
                                <th>Price</th>
                                <td>Rp. {{ number_format($course->course->price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="card-footer">
                        <form action="{{ route('lms.payments.store') }}" method="post">
                            @csrf

                            <input type="hidden" name="chart_id" value="{{ $course->id }}">

                            <button type="submit" class="btn btn-primary ms-1 float-end">Submit</button>
                        </form>
                        <a href="{{ route('lms.charts', auth()->user()->id) }}" class="btn btn-danger float-end">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
