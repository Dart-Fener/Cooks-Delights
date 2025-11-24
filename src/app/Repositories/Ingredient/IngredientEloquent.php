<?php

namespace App\Repositories\Ingredient;

use Illuminate\Support\Facades\DB;
use App\Models\Ingredient;
use App\Repositories\Ingredient\IngredientInterface;
use Illuminate\Support\Facades\Validator;

class IngredientEloquent implements IngredientInterface
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
            return Ingredient::updateOrInsert($data);
        }
    }

    public function listIngredients(array $data)
    {
        if(isset($data['wordIngr']) && $data['wordIngr']){

            $list = [];

            switch(true){
                case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                    $ingrList = DB::table('ingredients')->distinct()
                                    ->select('ingredients.id','ingredients.name')
                                    ->join('rec__ingr__meas__i_d_s','ingredients.id','=','rec__ingr__meas__i_d_s.ingredient_id')
                                    ->join('recipes','rec__ingr__meas__i_d_s.recipe_id','=','recipes.id')
                                    ->join('categories','recipes.category_id','=','categories.id')
                                    ->join('areas','recipes.area_id','areas.id')
                                    ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                    ->join('tags','recipe__tags.tag_id','=','tags.id')
                                    ->where('categories.id','=',$data['selCat'])
                                    ->where('areas.id','=',$data['selArea'])
                                    ->where('tags.id','=',$data['selTag'])
                                    ->where('ingredients.name','like',$data['wordIngr'] . '%')
                                    ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
                case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                    $ingrList = DB::table('ingredients')->distinct()
                                    ->select('ingredients.id','ingredients.name')
                                    ->join('rec__ingr__meas__i_d_s','ingredients.id','=','rec__ingr__meas__i_d_s.ingredient_id')
                                    ->join('recipes','rec__ingr__meas__i_d_s.recipe_id','=','recipes.id')
                                    ->join('categories','recipes.category_id','=','categories.id')
                                    ->join('areas','recipes.area_id','areas.id')
                                    ->where('categories.id','=',$data['selCat'])
                                    ->where('areas.id','=',$data['selArea'])
                                    ->where('ingredients.name','like',$data['wordIngr'] . '%')
                                    ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
                case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                    $ingrList = DB::table('ingredients')->distinct()
                                    ->select('ingredients.id','ingredients.name')
                                    ->join('rec__ingr__meas__i_d_s','ingredients.id','=','rec__ingr__meas__i_d_s.ingredient_id')
                                    ->join('recipes','rec__ingr__meas__i_d_s.recipe_id','=','recipes.id')
                                    ->join('categories','recipes.category_id','=','categories.id')
                                    ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                    ->join('tags','recipe__tags.tag_id','=','tags.id')
                                    ->where('categories.id','=',$data['selCat'])
                                    ->where('tags.id','=',$data['selTag'])
                                    ->where('ingredients.name','like',$data['wordIngr'] . '%')
                                    ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
                case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                    $ingrList = DB::table('ingredients')->distinct()
                                    ->select('ingredients.id','ingredients.name')
                                    ->join('rec__ingr__meas__i_d_s','ingredients.id','=','rec__ingr__meas__i_d_s.ingredient_id')
                                    ->join('recipes','rec__ingr__meas__i_d_s.recipe_id','=','recipes.id')
                                    ->join('areas','recipes.area_id','=','areas.id')
                                    ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                    ->join('tags','recipe__tags.tag_id','=','tags.id')
                                    ->where('areas.id','=',$data['selArea'])
                                    ->where('tags.id','=',$data['selTag'])
                                    ->where('ingredients.name','like',$data['wordIngr'] . '%')
                                    ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
                case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                    $ingrList = DB::table('ingredients')->distinct()
                                    ->select('ingredients.id','ingredients.name')
                                    ->join('rec__ingr__meas__i_d_s','ingredients.id','=','rec__ingr__meas__i_d_s.ingredient_id')
                                    ->join('recipes','rec__ingr__meas__i_d_s.recipe_id','=','recipes.id')
                                    ->join('categories','recipes.category_id','=','categories.id')
                                    ->where('categories.id','=',$data['selCat'])
                                    ->where('ingredients.name','like',$data['wordIngr'] . '%')
                                    ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
                case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                    $ingrList = DB::table('ingredients')->distinct()
                                    ->select('ingredients.id','ingredients.name')
                                    ->join('rec__ingr__meas__i_d_s','ingredients.id','=','rec__ingr__meas__i_d_s.ingredient_id')
                                    ->join('recipes','rec__ingr__meas__i_d_s.recipe_id','=','recipes.id')
                                    ->join('areas','recipes.area_id','=','areas.id')
                                    ->where('areas.id','=',$data['selArea'])
                                    ->where('ingredients.name','like',$data['wordIngr'] . '%')
                                    ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
                case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                    $ingrList = DB::table('ingredients')->distinct()
                                    ->select('ingredients.id','ingredients.name')
                                    ->join('rec__ingr__meas__i_d_s','ingredients.id','=','rec__ingr__meas__i_d_s.ingredient_id')
                                    ->join('recipes','rec__ingr__meas__i_d_s.recipe_id','=','recipes.id')
                                    ->join('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                    ->join('tags','recipe__tags.tag_id','=','tags.id')
                                    ->where('tags.id','=',$data['selTag'])
                                    ->where('ingredients.name','like',$data['wordIngr'] . '%')
                                    ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
                case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                    $ingrList = Ingredient::where('name', 'like', $data['wordIngr'] . '%')
                                            ->select('id', 'name')
                                            ->get();
                    foreach($ingrList as $ingr){ 
                        array_push($list,$ingr->name);
                    }
                    break;
            }

            return $list;

        }else{

            return null;
            
        }
    }

}