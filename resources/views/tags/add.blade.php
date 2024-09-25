@extends('layouts.index')

@section('title','Create Tag')

@section('content')

<h1 class="h3 mb-2 text-gray-800">Create Tag</h1>

<div class="row">
    <div class="col-md-12">
        <form action="{{ route('tags.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input
                    class="form-control"
                    type="text"
                    name="name"
                    required />
                
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input
                    class="form-control"
                    type="text"
                    name="description"
                    />
                
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@endsection