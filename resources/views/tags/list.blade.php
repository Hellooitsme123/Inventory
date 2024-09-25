@extends('layouts.index')

@section('title','Tags')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Tags List</h1>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>
                            {{ $tag->description}}
                        </td>
                        <td>
                            <a href="{{ route('tags.edit', ['id' => $tag->id]) }}" class="btn btn-primary btn-sm btn-circle">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="{{ route('tags.delete', ['id' => $tag->id]) }}" class="btn btn-danger btn-sm btn-circle">
                                <i class="fas fa-trash" onclick="return confirm('Do you want to delete this tag?')"></i>
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