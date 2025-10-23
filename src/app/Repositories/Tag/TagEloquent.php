<?php

namespace App\Repositories\Tag;

use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use App\Repositories\Tag\TagInterface;
use Illuminate\Support\Facades\Validator;

class TagEloquent implements TagInterface
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
            return Tag::updateOrInsert($data);
        }
    }

    public function listTags()
    {
        $queryTags = Tag::select('id','name')
                          ->orderBy('name','asc')
                          ->get();

        return $queryTags;
    }

    public function optionTagsSelected(array $data)
    {
        $queryTagSelect = ['<option value="0">Select Tag</option>'];

        switch(true){
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->join('areas', 'recipes.area_id', '=', 'areas.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('areas.id', '=', $data['selArea'])
                            ->where('tags.id','=',$data['selTag'])
                            ->where('ingredients.name','=',$data['wordIngr'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] != 0) && (isset($data['selArea']) && $data['selArea'] != 0) && (isset($data['selTag']) && $data['selTag'] != 0) && !isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->join('areas', 'recipes.area_id', '=', 'areas.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('areas.id', '=', $data['selArea'])
                            ->where('tags.id','=',$data['selTag'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor(isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->join('areas', 'recipes.area_id', '=', 'areas.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('areas.id', '=', $data['selArea'])
                            ->where('ingredients.name','=',$data['wordIngr'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor(isset($data['selTag']) && $data['selTag'] === '0')) && !isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->join('areas', 'recipes.area_id', '=', 'areas.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('areas.id', '=', $data['selArea'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('ingredients.name','=',$data['wordIngr'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('areas','recipes.area_id','=','areas.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('areas.id', '=', $data['selArea'])
                            ->where('ingredients.name','=',$data['wordIngr'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor(isset($data['selArea']) && $data['selArea'] === '0')) && !isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && !isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('areas', 'recipes.area_id', '=', 'areas.id')
                            ->where('areas.id', '=', $data['selArea'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && isset($data['wordIngr']):
                $optTag = DB::table('tags')->distinct()
                            ->select('tags.id', 'tags.name')
                            ->join('recipe__tags', 'tags.id', '=', 'recipe__tags.tag_id')
                            ->join('recipes', 'recipe__tags.recipe_id', '=', 'recipes.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('ingredients.name','=', $data['wordIngr'])
                            ->orderBy('tags.name', 'asc')
                            ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] === '0') && (isset($data['selArea']) && $data['selArea'] === '0') && !isset($data['wordIngr']):
                $optTag = Tag::select('id','name')
                                ->orderBy('name', 'asc')
                                ->get();
                foreach($optTag as $tagRow){
                    array_push($queryTagSelect,"<option value='".$tagRow->id."'>".$tagRow->name."</option>");
                }
                break;
        }

        return $queryTagSelect;
    }

}