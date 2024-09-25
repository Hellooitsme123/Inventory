@extends('layouts.index')

@section('title','Food Details')

@section('content')

<h1 class="h3 mb-2 text-gray-800">{{ $food->name }} - Details <a href="{{ route('food.edit', ['id' => $food->id]) }}" class="btn btn-warning btn-sm btn-circle">
        <i class="fas fa-pen"></i>
    </a>
    <a href="{{ route('food.delete', ['id' => $food->id]) }}" class="btn btn-danger btn-sm btn-circle">
        <i class="fas fa-trash" onclick="return confirm('Do you want to delete this food?')"></i>
    </a>
</h1>
<div class="row">
    <div class="card my-2 mx-2 col-4 h-25 border-primary up-border">
        <div class="card-body mx-0">
            <h4>
                <span class="float-left">
                    Quantity
                </span>

                <span class="float-right">{{ $food->quantity }}
                    <a
                        href="{{ route('food.increment',['id'=>$food->id]) }}"
                        class="btn btn-primary btn-sm mr-1">
                        <i class="fa fa-plus"></i></a><a
                        href="{{ route('food.decrement',['id'=>$food->id]) }}"
                        class="btn btn-primary btn-sm mr-1">
                        <i class="fa fa-minus"></i></a></span>
            </h4>
        </div>
    </div>
    <div class="card my-2 ml-2 col-4 border-secondary h-25 up-border">
        <div class="card-body mx-0">
            <h5>
                <span class="float-left mr-1">Quantity Unit</span>
                <span class="float-right mt-1 ml-2 h6">{{
                                $food->qty_unit
                            }}</span>


            </h5>
        </div>
    </div>
    <div class="card my-2 ml-2 col-2 h-25 border-red-800 up-border">
        <div class="card-body mx-0">
            <h4 class="card-title border-red-800">
                <span class="float-left">
                    ID
                </span>
                <span class="float-right">{{
                            $food->id
                        }}</span>
            </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="card my-2 mx-2 col-4 h-25 border-success up-border">
        <div class="card-body mx-0">
            <h4>
                <span class="float-left">
                    Location
                </span>
                <span class="float-right h5 mt-1">{{
                            $food->location
                        }}</span>
            </h4>
        </div>
    </div>
    <div class="card my-2 ml-2 col-4 h-25 border-warning up-border">
        <div class="card-body mx-0">
            <h5>
                <span class="float-left">
                    Expiration Date
                </span>
                <span class="float-right h6 mt-1">{{
                            $food->expiration_date
                        }}</span>
            </h5>
        </div>
    </div>
</div>
<div class="row">
    <div class="card my-2 mx-2 col-4 h-25 border-info up-border">
        <div class="card-body mx-0">
            <h5 class="overflow-scroll">
                <span class="float-left">
                    Tags
                </span>
                <span class="float-right h6 mt-1">{{
                            $food->first_product_tags
                        }}</span>
            </h5>
        </div>
    </div>
    <div class="card my-2 mx-2 col-4 h-25 border-teal-700 up-border">
        <div class="card-body mx-0">
            <h5 class="overflow-scroll">
                <span class="float-left">
                    Buy At
                </span>
                <span class="float-right">{{
                            $food->buy_at
                        }}</span>
            </h5>
        </div>
    </div>
</div>
<div class="row">
<div class="card mb-3 mx-2 col-8 h-25 border-dark up-border">
    <div class="card-body mx-0">
        <h5>
            Description
        </h5>
        <p>
            {{
                        $food->description
                    }}
        </p>
    </div>
</div>
</div>
<div class="row">
<div class="card my-3 mx-2 col-8 h-25 border-pink-700 up-border">
    <div class="card-body mx-0">
        <h5>
            Recipes
        </h5>
        <p>
        </p>
    </div>
</div>
</div>

@endsection