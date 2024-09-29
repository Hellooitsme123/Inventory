@extends('layouts.index')

@section('title','food')

@section('content')

<h1 class="h3 mb-2 text-gray-800">food List</h1>
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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Ingredients</th>
                        <th>Prep Time</th>
                        <th>Cook Time</th>
                        <th>Makes Amount</th>
                        <th>Available</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Ingredients</th>
                        <th>Prep Time</th>
                        <th>Cook Time</th>
                        <th>Makes Amount</th>
                        <th>Available</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($recipes as $recipe)
                    <tr>
                        <td>{{ $recipe->name }}</td>
                        <td>{{ $recipe->description }}</td>
                        <td>{{ $recipe->first_ingredients }}</td>
                        <td>{{ $recipe->prep_time }}</td>
                        <td>{{ $recipe->cook_time }}</td>
                        <td>{{ $recipe->makes_amount }}</td>
                        <td>{{ $recipe->available ? 'Yes' : 'No' }}</td>
                        <td><a href="{{ $recipe->link }}" target="_blank">Recipe</a></td>
                        <td>
                            <a href="{{ route('recipes.edit', ['id' => $recipe->id]) }}" class="btn btn-primary btn-sm btn-circle">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="{{ route('recipes.delete', ['id' => $recipe->id]) }}" class="btn btn-danger btn-sm btn-circle">
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