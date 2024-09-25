<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\TagsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('home');
});*/

Route::get('/',[HomeController::class,'index'])->name('dashboard');
Route::get('/help',function() {return view('help');})->name('help');

// AUTH
Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register',[AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login',[AuthController::class, 'handleLogin'])->name('handle.login');
Route::post('/register',[AuthController::class, 'handleRegister'])->name('handle.register');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');


Route::group(['middleware'=>'check.login'],function() {
    Route::group(['prefix'=>'food','as'=>'food.'],function() {
        Route::get('/', [FoodController::class, 'index'])->name('index');
        Route::get('add', [FoodController::class, 'create'])->name('create');
        Route::post('add', [FoodController::class, 'store'])->name('store');
        Route::get('edit/{id}', [FoodController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [FoodController::class, 'update'])->name('update');
        Route::get('delete/{id}', [FoodController::class, 'destroy'])->name('delete');
        Route::get('show/{id}', [FoodController::class, 'show'])->name('show');
        Route::get('search/{search}',[FoodController::class, 'search'])->name('search');
        Route::get('increment/{id}',[FoodController::class,'increment'])->name('increment');
        Route::get('decrement/{id}',[FoodController::class,'decrement'])->name('decrement');
    });
    Route::group(['prefix'=>'tags','as'=>'tags.'],function() {
        Route::get('/', [TagsController::class, 'index'])->name('index');
        Route::get('add', [TagsController::class, 'create'])->name('create');
        Route::post('add', [TagsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [TagsController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [TagsController::class, 'update'])->name('update');
        Route::get('delete/{id}', [TagsController::class, 'destroy'])->name('delete');
        Route::get('search/{search}',[TagsController::class, 'search'])->name('search');
    });
    Route::group(['prefix'=>'recipes','as'=>'recipes.'],function() {
        Route::get('/', [RecipesController::class, 'index'])->name('index');
        Route::get('add', [RecipesController::class, 'create'])->name('create');
        Route::post('add', [RecipesController::class, 'store'])->name('store');
        Route::get('edit/{id}', [RecipesController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [RecipesController::class, 'update'])->name('update');
        Route::get('delete/{id}', [RecipesController::class, 'destroy'])->name('delete');
        Route::get('search/{search}',[RecipesController::class, 'search'])->name('search');
    });
});