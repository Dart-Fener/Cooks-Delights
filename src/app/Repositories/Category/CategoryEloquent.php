<?php

namespace App\Repositories\Category;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Repositories\Category\CategoryInterface;
use Illuminate\Support\Facades\Validator;

class CategoryEloquent implements CategoryInterface
{
    public function updateOrInsert(array $data)
    {
        $validation = Validator::make($data,[
            'name' => 'required|string|max:255'
        ]);

        if($validation->fails()){
            return [
                'success' => false,
                'errors' => $validation->errors()
            ];
        }elseif($validation->passes()){
            return Category::updateOrInsert($data);
        }
    }

    public function listCategories()
    {
        $queryCategories = Category::select('id','name')
                                    ->orderBy('name','asc')
                                    ->get();

        return $queryCategories;
    }

    public function optionCategoriesSelected(array $data)
    {
        $queryCategSelect = ['<option value="0">Select Category</option>'];

        switch(true){
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                ->select('categories.id', 'categories.name')
                                ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                ->join('areas', 'areas.id', '=', 'recipes.area_id')
                                ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                ->join('tags','recipe__tags.tag_id','=','tags.id')
                                ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                ->where('categories.id', '=', $data['selCat'])
                                ->where('areas.id', '=', $data['selArea'])
                                ->where('tags.id','=',$data['selTag'])
                                ->where('ingredients.name','=',$data['wordIngr'])
                                ->orderBy('categories.name', 'asc')
                                ->get();
                foreach($optCategory as $cat){
                        array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                    }
                break;
            case (isset($data['selCat']) && $data['selCat'] != 0) && (isset($data['selArea']) && $data['selArea'] != 0) && (isset($data['selTag']) && $data['selTag'] != 0) && !isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                ->select('categories.id', 'categories.name')
                                ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                ->join('areas', 'areas.id', '=', 'recipes.area_id')
                                ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                ->join('tags','recipe__tags.tag_id','=','tags.id')
                                ->where('categories.id', '=', $data['selCat'])
                                ->where('areas.id', '=', $data['selArea'])
                                ->where('tags.id','=',$data['selTag'])
                                ->orderBy('categories.name', 'asc')
                                ->get();
                foreach($optCategory as $cat){
                        array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                    }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                ->select('categories.id', 'categories.name')
                                ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                ->where('areas.id', '=', $data['selArea'])
                                ->where('tags.id', '=', $data['selTag'])
                                ->where('ingredients.name','=',$data['wordIngr'])
                                ->orderBy('categories.name', 'asc')
                                ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] == 0) && (isset($data['selArea']) && $data['selArea'] != 0) && (isset($data['selTag']) && $data['selTag'] != 0) && !isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                ->select('categories.id', 'categories.name')
                                ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                ->where('areas.id', '=', $data['selArea'])
                                ->where('tags.id', '=', $data['selTag'])
                                ->orderBy('categories.name', 'asc')
                                ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
            case (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                   ->select('categories.id', 'categories.name')
                                   ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                   ->join('areas','recipes.area_id','=','areas.id')
                                   ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                   ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                   ->where('areas.id','=',$data['selArea'])
                                   ->where('ingredients.name','=', $data['wordIngr'])
                                   ->orderBy('categories.name', 'asc')
                                   ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
            case (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                   ->select('categories.id', 'categories.name')
                                   ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                   ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                   ->join('tags','recipe__tags.tag_id','=','tags.id')
                                   ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                   ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                   ->where('tags.id','=',$data['selTag'])
                                   ->where('ingredients.name','=', $data['wordIngr'])
                                   ->orderBy('categories.name', 'asc')
                                   ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
            case (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] == 0) && !isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                ->select('categories.id', 'categories.name')
                                ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                ->where('areas.id', '=', $data['selArea'])
                                ->orderBy('categories.name', 'asc')
                                ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
            case (isset($data['selArea']) && $data['selArea'] == 0) && (isset($data['selTag']) && $data['selTag'] != 0) && !isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                ->select('categories.id', 'categories.name')
                                ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                ->where('tags.id', '=', $data['selTag'])
                                ->orderBy('categories.name', 'asc')
                                ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
            case (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $optCategory = DB::table('categories')->distinct()
                                   ->select('categories.id', 'categories.name')
                                   ->join('recipes', 'categories.id', '=', 'recipes.category_id')
                                   ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                   ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                   ->where('ingredients.name','=', $data['wordIngr'])
                                   ->orderBy('categories.name', 'asc')
                                   ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
            case (isset($data['selArea']) && $data['selArea'] == 0) && (isset($data['selTag']) && $data['selTag'] == 0) && !isset($data['wordIngr']):
                $optCategory = Category::select('id','name')
                                        ->orderBy('name','asc')
                                        ->get();
                foreach($optCategory as $cat){
                    array_push($queryCategSelect,"<option value='".$cat->id."'>".$cat->name."</option>");
                }
                break;
        }

        return $queryCategSelect;
    }

}