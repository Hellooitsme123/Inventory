@extends('layouts.index')

@section('title','Dashboard')

@section('content')

@if (Auth::check())
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4" style="display:block;">
            <div class="card border-left-5 border-orange-400 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-orange-400 text-uppercase mb-1">
                                Total Food Items</div>
                            <div class="h5 mb-0 font-weight-bold text-orange-500">{{ $foodcount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-2x text-gray-300 fa-utensils"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@else
    <h3>You are not logged in. Please login to continue!</h3>
@endif

@endsection