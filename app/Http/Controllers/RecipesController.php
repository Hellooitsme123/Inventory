<?php

namespace App\Http\Controllers;

use App\Models\Recipes;
use App\Http\Controllers\Controller;
use App\Models\RecipeIngredients;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipes::where('user_id',Auth::user()->id)->get();
        $recipes = Recipes::getStringifiedIngredients($recipes,3,", ",1);
        $recipes = Recipes::checkAvailability($recipes);
        return view('recipes.list',compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ingredients = Food::where('user_id',Auth::user()->id)->get();
        return view('recipes.add',compact('ingredients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $recipe = new Recipes($request->except('ingredients','amounts'));
        $recipe->user_id = Auth::user()->id;
        $recipe->save();
        Recipes::addRecipeIngredients($recipe->id,$request->ingredients,$request->amounts);
        return redirect()->route('recipes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $recipe = Recipes::find($id);
        $recipe = Recipes::getIngredientsByRecipes($recipe); //
        $ingredients = Food::where('user_id',Auth::user()->id)->get();
        $recipeIngredients1 = RecipeIngredients::where('recipe_id',$recipe->id)->pluck('food_id')->toArray();
        $recipeIngredients = [];
        foreach ($recipeIngredients1 as $recipeIngredient) {
            array_push($recipeIngredients,Food::where('id',$recipeIngredient)->pluck('name')->toArray()[0]);
        } 
        return view('recipes.edit',compact('recipe','ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $recipe = Recipes::find($id);
        Recipes::addRecipeIngredients($id,$request->ingredients,$request->amounts);
        $recipe->update($request->except('ingredients','amounts'));
        return redirect()->route('recipes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $recipe = Recipes::find($id);
        $recipe->delete();
        return redirect()->back();
    }
}
