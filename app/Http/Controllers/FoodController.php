<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductTags;
use App\Models\Tags;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use DateTime;

class foodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::where('user_id',Auth::user()->id)->get();
        foreach ($foods as $food) {
            if ($food->expiration_date != null) {
                if (new DateTime($food->expiration_date) < new DateTime()) {
                    $food->expired = 2;
                } else {
                    if (round((strtotime($food->expiration_date) - strtotime("now"))/86400, 1) < 22) {
                        $food->expired = 1;
                    } else {
                        $food->expired = 0;
                    }
                }
            } else {
                $food->expired = 0;
            }
        }
        $foods = Food::getFirstTags($foods);
        return view('food.list',compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $tags = Tags::where('user_id',Auth::user()->id)->get();
        return view('food.add',compact('user_id','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => ['required',Rule::unique('food')->where(function ($query) {
                return $query->where('user_id', Auth::id());
            }),'max:80'],
            'description' => 'max:255',
            'quantity' => 'gte:0',
            'qty_unit' => 'max:40',
            'expiration_date' => ['nullable','regex:/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/'],
            'location' => 'max:100',
            'buy_at' => 'max:100',
        ]);
        $food = new Food($request->except('tags'));
        $food->save();
        Food::addProductTags($food->id,$request->tags);
        return redirect()->route('food.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $food = Food::find($id);
        $food = Food::getFirstTags($food,-1,", ");
        $foodTags1 = ProductTags::where('food_id',$food->id)->pluck('tag_id')->toArray();
        $foodTags = [];
        foreach ($foodTags1 as $tag) {
            array_push($foodTags,Tags::where('id',$tag)->pluck('name')->toArray()[0]);
        } 
        $recipes = Food::getRecipesByFood($food->id);
        $user_id = Auth::user()->id;
        return view('food.show',compact('food','user_id','recipes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $food = Food::find($id);
        $food = Food::getProductTagsByFoods($food);
        $tags = Tags::where('user_id',Auth::user()->id)->get();
        $user_id = Auth::user()->id;
        return view('food.edit',compact('food','user_id','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $food = Food::find($id);
        $validation = $request->validate([
            'name' => ['required','max:80'],
            'description' => 'max:255',
            'quantity' => 'gte:0',
            'qty_unit' => 'max:40',
            'tags' => 'max:150',
            'expiration_date' => ['nullable','regex:/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/'],
            'location' => 'max:100',
            'buy_at' => 'max:100',
        ]);
        Food::addProductTags($id,$request->tags);
        $food->update($request->except('tags'));
        return redirect()->route('food.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $food = Food::find($id);
        $food->delete();
        return redirect()->back();
    }

    public function searchfood($search) {
        $specialWords = ["@expired","@out_of_stock","@almost_expired"];
        $tempfoods = [];
        $product_tags = null;
        if (in_array($search,$specialWords)) {
            if ($search == "@expired") {
                $foods = food::where('user_id', Auth::user()->id)
                ->whereNotNull('expiration_date')
                ->where('expiration_date', '<', now())
                ->paginate(10);
            }
            if ($search == "@out_of_stock") {
                $foods = food::where('user_id', Auth::user()->id)
                ->where('quantity',0)
                ->paginate(10);
            }
            if ($search == "@almost_expired") {
                $foods = food::whereRaw("DATEDIFF(expiration_date, NOW()) <= 21")
                ->whereRaw("DATEDIFF(expiration_date, NOW()) >= 0")->where('user_id',Auth::user()->id)->paginate(10);
            }
            $product_tags = food::getProductTagsByfoods($foods); 
        } else {
            $tempfoods = food::where("name",'like','%' . $search. '%')->where('user_id',Auth::user()->id)->get(); 
            $foods = food::where("name",'like','%' . $search. '%')->where('user_id',Auth::user()->id)->paginate(10);
            $tagSearch = Tags::where("name",'like','%' . $search. '%')->where('user_id',Auth::user()->id)->get();
            foreach ($tagSearch as $tag) {
                $productTags = ProductTags::where("tag_id",$tag->id)->get();
                foreach ($productTags as $productTag) {
                    $foodByProductTag = food::find($productTag->food_id);
                    if ($tempfoods->contains('id',$foodByProductTag->id) == false) {
                        $tempfood = collect([$foodByProductTag]);
                        $foodsCollection = collect($foods->items());
                        $foodsCollection = $tempfood->merge($foodsCollection);
                        $foods->setCollection($foodsCollection);
                        $tempfoods = $tempfood->merge($tempfoods);
                    }
                    
                }
            }
            $product_tags = food::getProductTagsByfoods($tempfoods->all());
        }

        

        return view("food.search",compact("foods","product_tags"));
    }

    public function increment($id) {
        $food = Food::find($id);
        $food->increment('quantity');
        return redirect()->back();
    }

    public function decrement($id) {
        $food = Food::find($id);
        if ($food->quantity > 0) {
            $food->decrement('quantity');
        }
        return redirect()->back();
    }
}
