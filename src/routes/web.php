<?php

use App\Http\Controllers\RecipesController;
use App\Http\Controllers\SubscribeNewsletter;
use Illuminate\Support\Facades\Route;

Route::get('/', [RecipesController::class,'index'])->name('home');

Route::get('/palettes',[RecipesController::class,'palettes'])->name('palettes');

Route::get('/recipes-detailes/{slug}',[RecipesController::class,'recipeDetailes'])->name('recipe-detailes');

Route::group(['prefix' => '/recipes'], function(){
    Route::match(['get','post'],'/',[RecipesController::class,'recipesIndex'])->name('recipes');
    Route::match(['get','post'],'/request',[RecipesController::class,'recipesRequest'])->name('recipes.request');
});

Route::get('/about-us',[RecipesController::class,'aboutUs'])->name('aboutUs');

Route::resource('newsletter', SubscribeNewsletter::class)
        ->name('create','subscribe')
        ->name('store','subscribe.save');