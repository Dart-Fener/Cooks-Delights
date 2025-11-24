<?php

namespace App\Repositories\Area;

use Illuminate\Support\Facades\DB;
use App\Models\Area;
use App\Repositories\Area\AreaInterface;
use Illuminate\Support\Facades\Validator;

class AreaEloquent implements AreaInterface
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
            return Area::updateOrInsert($data);
        }
    }

    public function listAreas()
    {
        $queryArea = Area::select('id','name')
                            ->orderBy('name','asc')
                            ->get();

        return $queryArea;
    }

    public function optionAreaSelected(array $data)
    {
        $queryAreaSelect = ['<option value="0">Select Nationality</option>'];

        switch(true){
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                            ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('areas.id','=',$data['selArea'])
                            ->where('tags.id', '=', $data['selTag'])
                            ->where('ingredients.name','=',$data['wordIngr'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] != 0) && (isset($data['selArea']) && $data['selArea'] != 0) && (isset($data['selTag']) && $data['selTag'] != 0) && !isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                            ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('areas.id','=',$data['selArea'])
                            ->where('tags.id', '=', $data['selTag'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] != 0) && isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('categories', 'categories.id', '=', 'recipes.category_id')
                            ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                            ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('tags.id', '=', $data['selTag'])
                            ->where('ingredients.name','=',$data['wordIngr'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] != 0) && (isset($data['selArea']) && $data['selArea'] == 0) && (isset($data['selTag']) && $data['selTag'] != 0) && !isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('categories', 'categories.id', '=', 'recipes.category_id')
                            ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                            ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->where('tags.id', '=', $data['selTag'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('categories','recipes.category_id','=','categories.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('categories.id','=',$data['selCat'])
                            ->where('ingredients.name','=', $data['wordIngr'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (!isset($data['selCat']) xor(isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                            ->join('tags','recipe__tags.tag_id','=','tags.id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('tags.id','=',$data['selTag'])
                            ->where('ingredients.name','=', $data['wordIngr'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] != 0) && (isset($data['selTag']) && $data['selTag'] == 0) && !isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                            ->where('categories.id', '=', $data['selCat'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] == 0) && (isset($data['selTag']) && $data['selTag'] != 0) && !isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                            ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                            ->where('tags.id', '=', $data['selTag'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $optArea = DB::table('areas')->distinct()
                            ->select('areas.id', 'areas.name')
                            ->join('recipes', 'areas.id', '=', 'recipes.area_id')
                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                            ->where('ingredients.name','=', $data['wordIngr'])
                            ->orderBy('areas.name', 'asc')
                            ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] == 0) && (isset($data['selTag']) && $data['selTag'] == 0) && !isset($data['wordIngr']):
                $optArea = Area::select('id','name')
                                ->orderBy('name','asc')
                                ->get();
                foreach($optArea as $areaRow){
                    array_push($queryAreaSelect,"<option value='".$areaRow->id."'>".$areaRow->name."</option>");
                }
                break;
        }

        return $queryAreaSelect;
    }

}