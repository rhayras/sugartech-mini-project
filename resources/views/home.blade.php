@extends('layouts.app')

@section('content')
<div class="container pt-2">
    <div class="row mb-3">
        <div class="col-lg-12">
            <h3>Welcome {{ Auth::user()->first_name }}!</h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $maleCount }}</h5>
                    <p class="card-text">Male Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $femaleCount }}</h5>
                    <p class="card-text">Female Employees</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $averageAge }}</h5>
                    <p class="card-text">Average Age</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">P {{ number_format($totalSalary) }}</h5>
                    <p class="card-text">Total Monthly Salary</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
