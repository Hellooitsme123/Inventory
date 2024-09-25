@extends('layouts.index')

@section('title', 'Edit food')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Edit food</h1>

<div class="row">
    <div class="col-md-12">
        <form action="{{ route('food.update', ['id' => $food->id]) }}" method="POST" enctype="multipart/form-data">
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
                    name="name" value="{{ $food->name }}"
                    required />
                
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input
                    class="form-control"
                    type="text"
                    name="description" value="{{ $food->description }}"
                    />
                
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input
                    class="form-control"
                    type="number"
                    name="quantity" value="{{ $food->quantity }}"
                    />
                
            </div>
            <div class="form-group">
                <label for="qty_unit">Quantity Unit</label>
                <input
                    class="form-control"
                    type="text"
                    name="qty_unit" value="{{ $food->qty_unit }}"
                    />
                
            </div>
            <!--<div class="form-group">
                <label for="tags">Tags</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="tag1,tag2,tag3"
                    name="tags" value="{{ $food->first_product_tags }}"
                    />
                
            </div>-->
            <div class="form-group">
                <label for="expiration_date">Expiration Date</label>
                <input
                    class="form-control"
                    type="text"
                    name="expiration_date" value="{{ $food->expiration_date }}"
                   
                    placeholder="YYYY-MM-DD" />
                
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input
                    class="form-control"
                    type="text"
                    name="location" value="{{ $food->location }}"
                    />
                
            </div>
            <div class="form-group">
                <label for="buy_at">Buy At</label>
                <input
                    class="form-control"
                    type="text"
                    name="buy_at" value="{{ $food->buy_at }}"
                    />
                
            </div>
            <div id="tags">
                <div id="tagCount" data-count="{{ count($food->tags) }}"></div>
                @foreach($food->tags as $index => $tag)
                <div class="ingredient-row form-group">
                    <label for="tag">Tag:</label>
                    <div class="input-group mb-1">
                        <input type="text" name="tags[]" value="{{$tag->name}}" class="tag form-control form-control-sm col-3 d-inline" id="tag{{$index}}">
                        <span class="input-group-append"><button class="btn btn-primary btn-sm tag-select" type="button" data-toggle="modal" data-target="#tagModal" data-input="tag{{$index}}"><i class="fas fa-pen"></i></button></span>
                    </div>
                    <button type="button" class="removeTag btn btn-primary btn-sm">Remove</button>
                </div>
                
                @endforeach
            </div>
            <button type="button" class="btn btn-primary btn-sm mb-3" id="addTag">Add Tag</button>
            <div id="tagModal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title d-inline">Select Tag</h3>
                            <button type="button" class="close float-right d-inline" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body ">
                            <div class="form-group">
                                <input class="form-control" type="text" id="searchInput" placeholder="Search.." onkeyup="searchTags()">
                            </div>
                            <ul id="tag-list" style="max-height:60vh !important;overflow-y:scroll;">
                                <!-- Example tags; these could come from your database -->
                                @foreach ($tags as $tag)
                                    <li data-tag="{{$tag->name}}" data-dismiss="modal">{{ $tag->name}}</li>
                                @endforeach
                            </ul>

                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-primary">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<script>
    var selectedInputId = null;
    var tagCount = Number(document.getElementById("tagCount").getAttribute("data-count"));
    document.querySelectorAll('.tag-select').forEach(button => {
            button.addEventListener('click', function() {
                selectedInputId = this.getAttribute('data-input'); // Get the input ID to fill
            });
        });
    document.querySelectorAll('.removeTag').forEach(button =>{button.addEventListener('click', function() {
        button.parentElement.remove()});
    });
    function searchTags() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("tag-list");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i];
            txtValue = a.textContent;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    document.getElementById('addTag').addEventListener('click', function() {
        tagCount++;
        const tagsDiv = document.getElementById('tags');
        const newTagDiv = document.createElement('div');
        newTagDiv.classList.add('tag-row');
        newTagDiv.classList.add('form-group');

        // Add input field and a remove button for the new tag
        newTagDiv.innerHTML = `
        <label for="tag">Tag:</label>
        <div>
        <div class="input-group mb-1">
            <input type="text" name="tags[]" class="tag form-control form-control-sm col-3 d-inline" id="tag${tagCount}">
            <span class="input-group-append"><button class="btn btn-primary btn-sm tag-select" type="button" data-toggle="modal" data-target="#tagModal" data-input="tag${tagCount}"><i class="fas fa-pen"></i></button></span>
        </div>
        <button type="button" class="removeTag btn btn-primary btn-sm">Remove</button>
    `;

        // Append the new row
        tagsDiv.appendChild(newTagDiv);

        // Add event listener to the remove button
        newTagDiv.querySelector('.removeTag').addEventListener('click', function() {
            newTagDiv.remove();
        });
        document.querySelectorAll('.tag-select').forEach(button => {
            button.addEventListener('click', function() {
                selectedInputId = this.getAttribute('data-input'); // Get the input ID to fill
            });
        });
    });

    document.querySelectorAll('#tag-list li').forEach(item => {
        item.addEventListener('click', function() {
            const tag = this.getAttribute('data-tag');
            console.log(selectedInputId);
            if (selectedInputId) {
                console.log(selectedInputId);
                document.getElementById(selectedInputId).value = tag; // Autofill the tag input
            }
        });
    });
</script>
@endsection