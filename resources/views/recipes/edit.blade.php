@extends('layouts.index')

@section('title', 'Edit food')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Edit food</h1>

<div class="row">
    <div class="col-md-12">
        <form action="{{ route('recipes.update', ['id' => $recipe->id]) }}" method="POST" enctype="multipart/form-data">
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
                    name="name" value="{{ $recipe->name }}"
                    required />

            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input
                    class="form-control"
                    type="text"
                    name="description" value="{{ $recipe->description }}"/>

            </div>
            <div class="form-group">
                <label for="prep_time">Preparation Time</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="30 minutes.."
                    name="prep_time" value="{{ $recipe->prep_time }}"/>

            </div>
            <div class="form-group">
                <label for="cook_time">Cooking Time</label>
                <input
                    class="form-control"
                    type="text"
                    name="cook_time" value="{{ $recipe->cook_time }}"/>

            </div>
            <div class="form-group">
                <label for="rating">Rating</label>
                <input
                    class="form-control"
                    value="{{ $recipe->rating }}"
                    type="number"
                    name="rating"/>

            </div>
            <div class="form-group">
                <label for="instructions">Recipe Instructions</label>
                <textarea
                    class="form-control"
                    name="instructions"
                    rows="6"
                    value="{{ $recipe->instructions }}"
                    placeholder="Mix ingredients and let cool for 15 minutes.." ></textarea>

            </div>
            <div class="form-group">
                <label for="makes_amount">Makes Amount</label>
                <input
                    class="form-control"
                    type="text"
                    name="makes_amount"
                    value="{{ $recipe->makes_amount }}"
                    placeholder="5 pieces.." />

            </div>

            <div class="form-group">
                <label for="link">Link</label>
                <input
                    class="form-control"
                    type="text"
                    name="link"
                    value="{{ $recipe->link }}"
                    />

            </div>
            <div id="ingredients">
                <div id="ingredientCount" data-count="{{ count($recipe->ingredients) }}"></div>
                @foreach($recipe->ingredients as $index => $ingredient)
                <div class="ingredient-row form-group">
                    <label for="ingredient">Ingredient:</label>
                    <div class="input-group mb-1">
                        <input type="text" name="ingredients[]" class="ingredient form-control form-control-sm col-3 d-inline" id="ingredient{{$index}}" value="{{$ingredient->name}}">
                        <span class="input-group-append"><button class="btn btn-primary btn-sm ingredient-select" type="button" data-toggle="modal" data-target="#ingredientModal" data-input="ingredient{{$index}}"><i class="fas fa-pen"></i></button></span>
                    </div>
                    <label for="amount">Amount:</label><br>
                    <input type="text" name="amounts[]" value="{{$ingredient->amount}}" class="amount form-control form-control-sm col-3 d-inline">
                    <button type="button" class="removeIngredient btn btn-primary btn-sm">Remove</button>
                </div>
                
                @endforeach
                <!--<div class="ingredient-row form-group">
                    <label for="ingredient">Ingredient:</label>
                    <input type="text" name="ingredients[]" class="ingredient form-control form-control-sm">
                </div>-->
            </div>
            <button type="button" class="btn btn-primary btn-sm mb-3" id="addIngredient">Add Ingredient</button>
            <div id="ingredientModal" class="modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title d-inline">Select Ingredient</h3>
                            <button type="button" class="close float-right d-inline" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body ">
                            <div class="form-group">
                                <input class="form-control" type="text" id="searchInput" placeholder="Search.." onkeyup="searchIngredients()">
                            </div>
                            <ul id="ingredient-list" style="max-height:60vh !important;overflow-y:scroll;">
                                <!-- Example ingredients; these could come from your database -->
                                @foreach ($ingredients as $ingredient)
                                    <li data-ingredient="{{$ingredient->name}}" data-dismiss="modal">{{ $ingredient->name}}</li>
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
    var ingredientCount = Number(document.getElementById("ingredientCount").getAttribute("data-count"));
    document.querySelectorAll('.ingredient-select').forEach(button => {
            button.addEventListener('click', function() {
                selectedInputId = this.getAttribute('data-input'); // Get the input ID to fill
            });
        });
    document.querySelectorAll('.removeIngredient').forEach(button =>{button.addEventListener('click', function() {
        button.parentElement.remove()});
    });
    function searchIngredients() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("ingredient-list");
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
    document.getElementById('addIngredient').addEventListener('click', function() {
        ingredientCount++;
        const ingredientsDiv = document.getElementById('ingredients');
        const newIngredientDiv = document.createElement('div');
        newIngredientDiv.classList.add('ingredient-row');
        newIngredientDiv.classList.add('form-group');

        // Add input field and a remove button for the new ingredient
        newIngredientDiv.innerHTML = `
        <label for="ingredient">Ingredient:</label>
        <div>
        <div class="input-group mb-1">
            <input type="text" name="ingredients[]" class="ingredient form-control form-control-sm col-3 d-inline" id="ingredient${ingredientCount}">
            <span class="input-group-append"><button class="btn btn-primary btn-sm ingredient-select" type="button" data-toggle="modal" data-target="#ingredientModal" data-input="ingredient${ingredientCount}"><i class="fas fa-pen"></i></button></span>
        </div>
        <label for="amount">Amount:</label><br>
        <input type="text" name="amounts[]" class="amount form-control form-control-sm col-3 d-inline">
        <button type="button" class="removeIngredient btn btn-primary btn-sm">Remove</button>
    `;

        // Append the new row
        ingredientsDiv.appendChild(newIngredientDiv);

        // Add event listener to the remove button
        newIngredientDiv.querySelector('.removeIngredient').addEventListener('click', function() {
            newIngredientDiv.remove();
        });
        document.querySelectorAll('.ingredient-select').forEach(button => {
            button.addEventListener('click', function() {
                selectedInputId = this.getAttribute('data-input'); // Get the input ID to fill
            });
        });
    });

    document.querySelectorAll('#ingredient-list li').forEach(item => {
        item.addEventListener('click', function() {
            const ingredient = this.getAttribute('data-ingredient');
            if (selectedInputId) {
                document.getElementById(selectedInputId).value = ingredient; // Autofill the ingredient input
            }
        });
    });
</script>
@endsection