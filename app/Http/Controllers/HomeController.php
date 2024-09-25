<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;

class HomeController extends Controller
{
    public function index() {
        if (Auth::check()) {
            $foodcount = Food::where('user_id',Auth::user()->id)->get()->count();
        return view('dashboard.index',compact('foodcount'));
        } else {
            return view('dashboard.index');
        }
        
    }
}
