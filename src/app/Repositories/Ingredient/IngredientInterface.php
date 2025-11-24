<?php

namespace App\Repositories\Ingredient;

interface IngredientInterface
{
    public function updateOrInsert(array $data);

    public function listIngredients(array $data);

}