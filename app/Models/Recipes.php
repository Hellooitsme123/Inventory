<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecipeIngredients;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;

class Recipes extends Model
{
    use HasFactory;

    protected $table = "recipes";

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'prep_time',
        'cook_time',
        'rating',
        'instructions',
        'makes_amount',
        'image',
    ];

    public static function getIngredientsByRecipes($recipes)
    {
        //$ingredients = (object)[];
        if ($recipes instanceof Recipes) {
            $recipe = $recipes;
            $temp_ingredients = RecipeIngredients::where('recipe_id', $recipe->id)->get();
            $temp_ingredients2 = [];
            foreach ($temp_ingredients as $temp_ingredient) {
                $recipe_ingredient = Food::where('id', $temp_ingredient->food_id)->get()[0];
                $recipe_ingredient->amount = $temp_ingredient->amount;
                array_push($temp_ingredients2, $recipe_ingredient);
            }
            $recipe->ingredients = $temp_ingredients2;
            return $recipe;
        } else {
            foreach ($recipes as $recipe) {
                $temp_ingredients = RecipeIngredients::where('recipe_id', $recipe->id)->get();
                $temp_ingredients2 = [];
                foreach ($temp_ingredients as $temp_ingredient) {
                    $recipe_ingredient = Food::where('id', $temp_ingredient->food_id)->get()[0];
                    $recipe_ingredient->amount = $temp_ingredient->amount;
                    array_push($temp_ingredients2, $recipe_ingredient);
                }
                $recipe->ingredients = $temp_ingredients2;
            }
        }

        return $recipes;
    }
    public static function getStringifiedIngredients($recipes, $amount = 3, $delimiter = ", ", $showAmount = 0)
    {
        //$ingredients = (object)[];
        foreach ($recipes as $recipe) {
            $temp_ingredients = RecipeIngredients::where('recipe_id', $recipe->id)->get();
            $temp_ingredients2 = [];
            $index = 0;
            foreach ($temp_ingredients as $temp_ingredient) {
                $temp_ingredient2 = Food::where('id', $temp_ingredient->food_id)->get()[0]->name;
                if ($showAmount == 1) {
                    $temp_ingredient2 = $temp_ingredient->amount . " of " . $temp_ingredient2;
                }
                array_push($temp_ingredients2, $temp_ingredient2);
                $index++;
                if ($index == $amount) {
                    break;
                }
            }
            $recipe->first_ingredients = implode($delimiter, $temp_ingredients2);
        }
        return $recipes;
    }
    public static function validateIngredients($recipe, $ingredients)
    {
        if ($ingredients == null) {
            $current_recipe_ingredients = RecipeIngredients::where('recipe_id', $recipe->id)->get();
            foreach ($current_recipe_ingredients as $ingredient) {
                $ingredient2 = RecipeIngredients::find($ingredient->id);
                $ingredient2->delete();
            }
            return false;
        }
        if (gettype($ingredients) == "string") {
            $ingredients = explode(',', $ingredients);
        }
        $current_recipe_ingredients = RecipeIngredients::where('recipe_id', $recipe->id)->get();
        foreach ($current_recipe_ingredients as $ingredient) {
            $ingredientname = $ingredient->name;
            //$ingredientname = RecipeIngredients::where('id', $ingredient->ingredient_id)->get()[0]->name;
            if (in_array($ingredientname, $ingredients) == false) {
                $ingredient2 = RecipeIngredients::find($ingredient->id);

                $ingredient2->delete();
            }
        }
        foreach ($ingredients as $ingredient) {
            $existingIngredients = Food::where('name', $ingredient)->where('user_id', Auth::user()->id)->get();
            if (count($existingIngredients) > 0) {
                $ingredient2 = $existingIngredients[0];
                if (count(RecipeIngredients::where('food_id', $ingredient2->id)->where('recipe_id', $recipe->id)->get()) == 0) {
                    $tag3 = new RecipeIngredients();
                    $tag3->food_id = $ingredient2->id;
                    $tag3->recipe_id = $recipe->id;
                    $tag3->save();
                }
            }
        }
    }
    public static function addRecipeIngredients($id, $ingredients, $amounts)
    {
        $recipe = Recipes::find($id);
        if ($ingredients == null) {
            return false;
        }
        if (gettype($ingredients) == "string") {
            $ingredients = explode(',', $ingredients);
        }
        $existingRecipeIngredients = RecipeIngredients::where('recipe_id', $id)->get();
        if (count($existingRecipeIngredients) > 0) {
            foreach ($existingRecipeIngredients as $existingRecipeIngredient) {
                if (in_array($existingRecipeIngredient->name,array_column($ingredients,'name')) == false) {
                    $existingRecipeIngredient->delete();
                }
            }
        }
        $index = 0;
        foreach ($ingredients as $ingredient) {
            $existingIngredients = Food::where('name', $ingredient)->where('user_id', Auth::user()->id)->get();

            if (count($existingIngredients) > 0) {
                $existingIngredient = $existingIngredients[0];
                $recipeIngredients = RecipeIngredients::where('food_id', $existingIngredient->id)->where('recipe_id', $id)->get();
                if (count($recipeIngredients) > 0) {
                    $recipeIngredients[0]->update(['food_id' => $existingIngredient->id, 'recipe_id' => $id, 'amount' => $amounts[$index]]);
                } else {
                    $tag2 = new RecipeIngredients();
                    $tag2->food_id = $existingIngredient->id;
                    $tag2->recipe_id = $id;
                    $tag2->amount = $amounts[$index];
                    $tag2->save();
                }
            }
            $index++;
        }
    }

    public static function checkAvailability($recipes)
    {
        if ($recipes instanceof Recipes) {
            $recipe = $recipes;
            $tempAvailable = true;
            $ingredients = RecipeIngredients::where('recipe_id', $recipe->id)->get();
            foreach ($ingredients as $ingredient) {
                $tempIngredient = Food::find($ingredient->food_id);
                if ($tempIngredient->quantity == 0 || $tempIngredient->quantity == null) {
                    $tempAvailable = false;
                }
            }
            $recipe->available = $tempAvailable;
            return $recipe;
        } else {
            foreach ($recipes as $recipe) {
                $tempAvailable = true;
                $ingredients = RecipeIngredients::where('recipe_id', $recipe->id)->get();
                foreach ($ingredients as $ingredient) {
                    $tempIngredient = Food::find($ingredient->food_id);
                    if ($tempIngredient->quantity == 0 || $tempIngredient->quantity == null) {
                        $tempAvailable = false;
                    }
                }
                $recipe->available = $tempAvailable;
            }
        }
        return $recipes;
    }
}
