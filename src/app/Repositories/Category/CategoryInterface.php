<?php

namespace App\Repositories\Category;

interface CategoryInterface
{
    public function updateOrInsert(array $data);

    public function listCategories();

    public function optionCategoriesSelected(array $data);

}