<?php

namespace App\Repositories\Recipe;

interface RecipeInterface
{
    public function insertOrIgnore(array $data);

    public function randomCards();

    public function listRecipes(array $data);

    public function recipeDetailes($slug);

    public function cardsTitle(array $data);

}