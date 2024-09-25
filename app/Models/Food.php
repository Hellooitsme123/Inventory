<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductTags;
use App\Models\Tags;
use Illuminate\Support\Facades\Auth;

class Food extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "food";

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'image',
        'user_id',
        "location",
        "buy_at",
        "qty_unit",
        "expiration_date",
    ];


    public static function getFirstTags($foods,$amount = 3,$delimiter=", ") {
        $tags = [];
        if ($foods instanceof Food) {
            $food = $foods;
            $temp_tags = ProductTags::where('food_id', $food->id)->get();
            $temp_tags2 = [];
            $index = 0;
            foreach ($temp_tags as $temp_tag) {
                array_push($temp_tags2,Tags::find($temp_tag->tag_id)->name);
                array_push($tags,$temp_tags);
                $index++;
                if ($index == $amount) {
                    break;
                }
            }
            if ($temp_tags2 == null) {
                $food->first_product_tags = "None";
            } else {
                $food->first_product_tags = implode($delimiter,$temp_tags2);
                //dd($food->first_product_tags);
                array_push($tags,$food->first_product_tags);
            }
        } else {
            foreach ($foods as $food) {
                $temp_tags = ProductTags::where('food_id', $food->id)->get();
                $temp_tags2 = [];
                $index = 0;
                foreach ($temp_tags as $temp_tag) {
                    array_push($temp_tags2,Tags::find($temp_tag->tag_id)->name);
                    array_push($tags,$temp_tags);
                    $index++;
                    if ($index == $amount) {
                        break;
                    }
                }
                if ($temp_tags2 == null) {
                    $food->first_product_tags = "None";
                } else {
                    $food->first_product_tags = implode($delimiter,$temp_tags2);
                    array_push($tags,$food->first_product_tags);
                }
                
            }
        }
        
        return $foods;
    }
    public static function getProductTagsByFoods($foods)
    {
        $tags = [];
        if ($foods instanceof Food) {
            $food = $foods;
            $temp_tags = ProductTags::where('food_id', $food->id)->get();
            $temp_tags2 = [];
            $index = 0;
            foreach ($temp_tags as $temp_tag) {
                array_push($temp_tags2,Tags::find($temp_tag->tag_id));
                array_push($tags,$temp_tags);
                $index++;
                if ($index == -1) {
                    break;
                }
            }
            $food->tags = $temp_tags2;
        } else {
            foreach ($foods as $food) {
                $temp_tags = ProductTags::where('food_id', $food->id)->get();
                $temp_tags2 = [];
                $index = 0;
                foreach ($temp_tags as $temp_tag) {
                    array_push($temp_tags2,Tags::find($temp_tag->tag_id));
                    array_push($tags,$temp_tags);
                    $index++;
                    if ($index == -1) {
                        break;
                    }
                }
                $food->tags = $temp_tags2;
                
            }
        }
        
        return $foods;
    }
    public static function validateTags($food, $tags)
    {
        if ($tags == null) {
            $current_food_tags = ProductTags::where('food_id', $food->id)->get();
            foreach ($current_food_tags as $tag) {
                $tag2 = ProductTags::find($tag->id);
                $tag2->delete();
            }
            return false;
        }
        if (gettype($tags) == "string") {
            $tags = explode(',', $tags);
        }
        $current_food_tags = ProductTags::where('food_id', $food->id)->get();
        foreach ($current_food_tags as $tag) {
            $tagname = Tags::where('id', $tag->tag_id)->get()[0]->name;
            if (in_array($tagname, $tags) == false) {
                $tag2 = ProductTags::find($tag->id);
                $tag2->delete();
            }
        }
        foreach ($tags as $tag) {
            $existingTags = Tags::where('name', $tag)->where('user_id', Auth::user()->id)->get();
            if (count($existingTags) > 0) {
                $tag2 = $existingTags[0];
                if (count(ProductTags::where('tag_id', $tag2->id)->where('food_id', $food->id)->get()) == 0) {
                    $tag3 = new ProductTags();
                    $tag3->tag_id = $tag2->id;
                    $tag3->food_id = $food->id;
                    $tag3->save();
                }
            }
        }
    }
    public static function addProductTags($id, $tags)
    {
        if ($tags == null) {
            return false;
        }
        if (gettype($tags) == "string") {
            $tags = explode(',', $tags);
        }
        $existingTags1 = ProductTags::where('food_id', $id)->get();
        if (count($existingTags1) > 0) {
            foreach ($existingTags1 as $existingTag1) {
                if (in_array($existingTag1->name,array_column($tags,'name')) == false) {
                    $existingTag1->delete();
                }
            }
        }
        foreach ($tags as $tag) {
            $existingTags = Tags::where('name', $tag)->where('user_id', Auth::user()->id)->get();
            if (count($existingTags) > 0) {
                $existingTag = $existingTags[0];
                $tag2 = new ProductTags();
                $tag2->tag_id = $existingTag->id;
                $tag2->food_id = $id;
                $tag2->save();
            }
        }
    }

    public static function getRecipesByFood($id) {
        $recipeIngredients = RecipeIngredients::where("food_id",$id)->pluck("recipe_id");
        $recipes = Recipes::whereIn('id',$recipeIngredients)->get();
        return $recipes;
    }
}
