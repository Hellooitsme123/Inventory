@extends('layouts.index')

@section('title','Food')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Food List</h1>
@if(Session::has('success'))
<div class="alert alert-success alert-dismissible mt-4">
    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{ Session::get('success')}}
</div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible mt-4">
    <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {{Session::get('error')}}
</div>
@endif
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered foodTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Quantity Unit</th>
                        <th>Tags</th>
                        <th>Expires At</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>Name</th>
                        <th>Quantity</th>
                        <th>Quantity Unit</th>
                        <th>Tags</th>
                        <th>Expires At</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($foods as $food)
                    <tr>
                        <td>{{ $food->name }}</td>
                        <td>
                            @if ($food->quantity > 0)
                            <span>{{ $food->quantity }}</span>
                            @else
                            <span
                                v-else-if="food.quantity == 0"
                                class="text-danger"><b>Out Of Stock!</b></span>
                            @endif
                            <!--<span v-if="food.quantity > 0"></span><span
                                v-else-if="food.quantity == 0"
                                class="text-danger"><b>Out Of Stock!</b></span><span v-else>...</span>-->
                        </td>
                        <td>{{ $food->qty_unit }}</td>
                        <td>
                            <span>{{ $food->first_product_tags }}
                            </span>
                        </td>
                        <td>
                            @if ($food->expired == 2)
                            <span class="text-danger">
                                <b>{{ $food->expiration_date }}</b>
                            </span>
                            @elseif ($food->expired == 1)
                            <span class="text-orange-400">
                                <b>{{ $food->expiration_date }}</b>
                            </span>
                            @else
                            <span v-else>
                                {{ $food->expiration_date }}
                            </span>
                            @endif
                        </td>
                        <td>
                            {{ $food->location }}
                        </td>
                        <td>
                            <a href="{{ route('food.edit', ['id' => $food->id]) }}" class="btn btn-primary btn-sm btn-circle">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="{{ route('food.show', ['id' => $food->id]) }}" class="btn btn-info btn-sm btn-circle">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('food.delete', ['id' => $food->id]) }}" class="btn btn-danger btn-sm btn-circle">
                                <i class="fas fa-trash" onclick="return confirm('Do you want to delete this $food?')"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection