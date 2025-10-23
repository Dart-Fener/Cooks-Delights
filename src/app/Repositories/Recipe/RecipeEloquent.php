<?php

namespace App\Repositories\Recipe;

use App\Models\Recipe;
use App\Repositories\Recipe\RecipeInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Area;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;

class RecipeEloquent implements RecipeInterface
{
    public function insertOrIgnore(array $data)
    {
        $validation = Validator::make($data,[
            'id' => 'required|integer',
            'slug' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'instruction' => 'nullable|string',
            'thumb' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'area_id' => 'required|integer'
        ]);

        if($validation->fails()){
            return [
                'success' => false,
                'errors' => $validation->errors()
            ];
        }elseif($validation->passes()){
            return Recipe::insertOrIgnore([$data]);
        }
    }

    public function randomCards()
    {
        $queryRecipeDetailes = DB::table('recipes')
                                    ->distinct()
                                    ->limit(12)
                                    ->inRandomOrder()
                                    ->select(
                                        'recipes.id',
                                        'recipes.slug',
                                        'recipes.name as recipe',
                                        'recipes.thumb',
                                        'areas.name as area',
                                        'categories.name as category',
                                        DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                    )
                                    ->join('areas','recipes.area_id','=','areas.id')
                                    ->join('categories','recipes.category_id','=','categories.id')
                                    ->leftJoin('recipe__tags','recipes.id','=','recipe__tags.recipe_id')
                                    ->leftJoin('tags','recipe__tags.tag_id','=','tags.id')
                                    ->groupBy('recipes.id')
                                    ->get();
        
        return $queryRecipeDetailes;
    }

    public function listRecipes(array $data)
    {
        $queryListRecipes = [];

        function htmlCards($card){
            $buildCards = "<div class='card'>";
            $buildCards .= "<div class='inner-card'>";
            $buildCards .= "<img class='cardImg' src='".$card->thumb."' alt='".$card->recipe."'>";
            $buildCards .= "<img class='paletteCardIcon' src='assets/img/icon/category/".$card->category.".svg' alt='".        $card->category."-Icon'>";
            $buildCards .= "<h5>".$card->recipe."</h5>";
            $buildCards .= "<h6>Category:<span>".$card->category."</span></h6>";
            $buildCards .= "<h6>Nationality:<span>".$card->area."</span></h6>";
            if($card->tags){
                $buildCards .= '<h6>Tags:<span>'.$card->tags.'</span></h6>';
            }
            $buildCards .= "</div>";
            $buildCards .= "<a href='recipes-detailes/".$card->slug."' class='emptyBackButton' target='_blank'>VIEW RECIPE</a>";
            $buildCards .= "</div>";

            return $buildCards;
        }

        switch(true){
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $cardsCategAreaTagIngr = DB::table('recipes')->distinct()
                                            ->select(
                                                'recipes.id',
                                                'recipes.slug',
                                                'recipes.name as recipe',
                                                'recipes.thumb',
                                                'areas.name as area',
                                                'categories.name as category',
                                                DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                            )
                                            ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                            ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                            ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                            ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                            ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                            ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                            ->where('categories.id','=', $data['selCat'])
                                            ->where('areas.id','=', $data['selArea'])
                                            ->where('tags.id','=', $data['selTag'])
                                            ->where('ingredients.name','=', $data['wordIngr'])
                                            ->orderBy('recipes.name', 'asc')
                                            ->groupBy('recipes.id')
                                            ->get();
                foreach($cardsCategAreaTagIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && !isset($data['wordIngr']):
                $cardsCategAreaTag = DB::table('recipes')->distinct()
                                        ->select(
                                            'recipes.id',
                                            'recipes.slug',
                                            'recipes.name as recipe',
                                            'recipes.thumb',
                                            'areas.name as area',
                                            'categories.name as category',
                                            DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                        )
                                        ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                        ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                        ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                        ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                        ->where('categories.id','=', $data['selCat'])
                                        ->where('areas.id','=', $data['selArea'])
                                        ->where('tags.id','=', $data['selTag'])
                                        ->orderBy('recipes.name', 'asc')
                                        ->groupBy('recipes.id')
                                        ->get();
                foreach($cardsCategAreaTag as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $cardsCategAreaIngr = DB::table('recipes')->distinct()
                                        ->select(
                                                'recipes.id',
                                                'recipes.slug',
                                                'recipes.name as recipe',
                                                'recipes.thumb',
                                                'areas.name as area',
                                                'categories.name as category',
                                                DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                            )
                                        ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                        ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                        ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                        ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                        ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                        ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                        ->where('categories.id','=', $data['selCat'])
                                        ->where('areas.id','=', $data['selArea'])
                                        ->where('ingredients.name','=', $data['wordIngr'])
                                        ->orderBy('recipes.name', 'asc')
                                        ->groupBy('recipes.id')
                                        ->get();
                foreach($cardsCategAreaIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $cardsCategTagIngr = DB::table('recipes')->distinct()
                                        ->select(
                                            'recipes.id',
                                            'recipes.slug',
                                            'recipes.name as recipe',
                                            'recipes.thumb',
                                            'areas.name as area',
                                            'categories.name as category',
                                            DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                        )
                                        ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                        ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                        ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                        ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                        ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                        ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                        ->where('categories.id','=', $data['selCat'])
                                        ->where('tags.id','=', $data['selTag'])
                                        ->where('ingredients.name','=', $data['wordIngr'])
                                        ->orderBy('recipes.name', 'asc')
                                        ->groupBy('recipes.id')
                                        ->get();
                foreach($cardsCategTagIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $cardsAreaTagIngr = DB::table('recipes')->distinct()
                                        ->select(
                                            'recipes.id',
                                            'recipes.slug',
                                            'recipes.name as recipe',
                                            'recipes.thumb',
                                            'areas.name as area',
                                            'categories.name as category',
                                            DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                        )
                                        ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                        ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                        ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                        ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                        ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                        ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                        ->where('areas.id','=', $data['selArea'])
                                        ->where('tags.id','=', $data['selTag'])
                                        ->where('ingredients.name','=', $data['wordIngr'])
                                        ->orderBy('recipes.name', 'asc')
                                        ->groupBy('recipes.id')
                                        ->get();
                foreach($cardsAreaTagIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && !isset($data['wordIngr']):
                $cardsCategArea = DB::table('recipes')->distinct()
                                    ->select(
                                            'recipes.id',
                                            'recipes.slug',
                                            'recipes.name as recipe',
                                            'recipes.thumb',
                                            'areas.name as area',
                                            'categories.name as category',
                                            DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                        )
                                    ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                    ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                    ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                    ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                    ->where('categories.id','=', $data['selCat'])
                                    ->where('areas.id','=', $data['selArea'])
                                    ->orderBy('recipes.name', 'asc')
                                    ->groupBy('recipes.id')
                                    ->get();
                foreach($cardsCategArea as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && !isset($data['wordIngr']):
                $cardsCategTag = DB::table('recipes')->distinct()
                                    ->select(
                                        'recipes.id',
                                        'recipes.slug',
                                        'recipes.name as recipe',
                                        'recipes.thumb',
                                        'areas.name as area',
                                        'categories.name as category',
                                        DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                    )
                                    ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                    ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                    ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                    ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                    ->where('categories.id','=', $data['selCat'])
                                    ->where('tags.id','=',$data['selTag'])
                                    ->orderBy('recipes.name', 'asc')
                                    ->groupBy('recipes.id')
                                    ->get();
                foreach($cardsCategTag as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && (isset($data['selTag']) && $data['selTag'] !== '0') && !isset($data['wordIngr']):
                $cardsAreaTag = DB::table('recipes')->distinct()
                                    ->select(
                                        'recipes.id',
                                        'recipes.slug',
                                        'recipes.name as recipe',
                                        'recipes.thumb',
                                        'areas.name as area',
                                        'categories.name as category',
                                        DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                    )
                                    ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                    ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                    ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                    ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                    ->where('areas.id','=', $data['selArea'])
                                    ->where('tags.id','=', $data['selTag'])
                                    ->orderBy('recipes.name', 'asc')
                                    ->groupBy('recipes.id')
                                    ->get();
                foreach($cardsAreaTag as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $cardsCategIngr = DB::table('recipes')->distinct()
                                    ->select(
                                            'recipes.id',
                                            'recipes.slug',
                                            'recipes.name as recipe',
                                            'recipes.thumb',
                                            'areas.name as area',
                                            'categories.name as category',
                                            DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                        )
                                    ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                    ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                    ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                    ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                    ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                    ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                    ->where('categories.id','=', $data['selCat'])
                                    ->where('ingredients.name','=', $data['wordIngr'])
                                    ->orderBy('recipes.name', 'asc')
                                    ->groupBy('recipes.id')
                                    ->get();
                foreach($cardsCategIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $cardsAreaIngr = DB::table('recipes')->distinct()
                                    ->select(
                                        'recipes.id',
                                        'recipes.slug',
                                        'recipes.name as recipe',
                                        'recipes.thumb',
                                        'areas.name as area',
                                        'categories.name as category',
                                        DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                    )
                                    ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                    ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                    ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                    ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                    ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                    ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                    ->where('areas.id','=', $data['selArea'])
                                    ->where('ingredients.name','=', $data['wordIngr'])
                                    ->orderBy('recipes.name', 'asc')
                                    ->groupBy('recipes.id')
                                    ->get();
                foreach($cardsAreaIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && isset($data['wordIngr']):
                $cardsTagIngr = DB::table('recipes')->distinct()
                                    ->select(
                                        'recipes.id',
                                        'recipes.slug',
                                        'recipes.name as recipe',
                                        'recipes.thumb',
                                        'areas.name as area',
                                        'categories.name as category',
                                        DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                    )
                                    ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                    ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                    ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                    ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                    ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                    ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                    ->where('tags.id','=',$data['selTag'])
                                    ->where('ingredients.name','=', $data['wordIngr'])
                                    ->orderBy('recipes.name', 'asc')
                                    ->groupBy('recipes.id')
                                    ->get();
                foreach($cardsTagIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (isset($data['selCat']) && $data['selCat'] !== '0') && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && !isset($data['wordIngr']):
                $cardsCategory = DB::table('recipes')->distinct()
                                    ->select(
                                        'recipes.id',
                                        'recipes.slug',
                                        'recipes.name as recipe',
                                        'recipes.thumb',
                                        'areas.name as area',
                                        'categories.name as category',
                                        DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                    )
                                    ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                    ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                    ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                    ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                    ->where('categories.id','=', $data['selCat'])
                                    ->orderBy('recipes.name', 'asc')
                                    ->groupBy('recipes.id')
                                    ->get();
                foreach($cardsCategory as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (isset($data['selArea']) && $data['selArea'] !== '0') && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && !isset($data['wordIngr']):
                $cardsArea = DB::table('recipes')->distinct()
                                ->select(
                                    'recipes.id',
                                    'recipes.slug',
                                    'recipes.name as recipe',
                                    'recipes.thumb',
                                    'areas.name as area',
                                    'categories.name as category',
                                    DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                )
                                ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                ->where('areas.id','=', $data['selArea'])
                                ->orderBy('recipes.name', 'asc')
                                ->groupBy('recipes.id')
                                ->get();
                foreach($cardsArea as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (isset($data['selTag']) && $data['selTag'] !== '0') && !isset($data['wordIngr']):
                $cardsTag = DB::table('recipes')->distinct()
                                ->select(
                                    'recipes.id',
                                    'recipes.slug',
                                    'recipes.name as recipe',
                                    'recipes.thumb',
                                    'areas.name as area',
                                    'categories.name as category',
                                    DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                )
                                ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                ->join('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                ->join('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                ->where('tags.id','=', $data['selTag'])
                                ->orderBy('recipes.name', 'asc')
                                ->groupBy('recipes.id')
                                ->get();
                foreach($cardsTag as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;
            case (!isset($data['selCat']) xor (isset($data['selCat']) && $data['selCat'] === '0')) && (!isset($data['selArea']) xor (isset($data['selArea']) && $data['selArea'] === '0')) && (!isset($data['selTag']) xor (isset($data['selTag']) && $data['selTag'] === '0')) && isset($data['wordIngr']):
                $cardsIngr = DB::table('recipes')->distinct()
                                ->select(
                                    'recipes.id',
                                    'recipes.slug',
                                    'recipes.name as recipe',
                                    'recipes.thumb',
                                    'areas.name as area',
                                    'categories.name as category',
                                    DB::raw("group_concat(tags.name order by tags.name asc separator ' - ') as tags")
                                )
                                ->join('areas', 'recipes.area_id', '=', 'areas.id')
                                ->join('categories', 'recipes.category_id', '=', 'categories.id')
                                ->join('rec__ingr__meas__i_d_s', 'recipes.id', '=', 'rec__ingr__meas__i_d_s.recipe_id')
                                ->join('ingredients', 'rec__ingr__meas__i_d_s.ingredient_id', '=', 'ingredients.id')
                                ->leftJoin('recipe__tags', 'recipes.id', '=', 'recipe__tags.recipe_id')
                                ->leftJoin('tags', 'recipe__tags.tag_id', '=', 'tags.id')
                                ->where('ingredients.name','=', $data['wordIngr'])
                                ->orderBy('recipes.name', 'asc')
                                ->groupBy('recipes.id')
                                ->get();
                foreach($cardsIngr as $card){
                    $htmlCards = htmlCards($card);
                    array_push($queryListRecipes,$htmlCards);
                }
                break;      
        }
        
        return $queryListRecipes;
    }

    public function recipeDetailes($slug)
    {
        $queryDetailes = DB::table('recipes')
                            ->select(
                                'recipes.name',
                                'recipes.instruction',
                                'recipes.thumb',
                                'categories.name as category',
                                'areas.name as area',
                                DB::raw('json_objectagg(measures.name,ingredients.name) as list') //Generate an json object as list
                            )
                            ->join('categories','recipes.category_id','=','categories.id')
                            ->join('areas','recipes.area_id','=','areas.id')
                            ->join('rec__ingr__meas__i_d_s','recipes.id','=','rec__ingr__meas__i_d_s.recipe_id')
                            ->join('ingredients','rec__ingr__meas__i_d_s.ingredient_id','=','ingredients.id')
                            ->join('measures','rec__ingr__meas__i_d_s.measure_id','=','measures.id')
                            ->where('recipes.slug','=',$slug)
                            ->groupBy('recipes.id')
                            ->get();

        return $queryDetailes;
    }

    public function cardsTitle(array $data)
    {
        if((isset($data['selCat']) && $data['selCat'] != 0) || (isset($data['selArea']) && $data['selArea'] != 0) || (isset($data['selTag']) && $data['selTag'] != 0) || isset($data['wordIngr'])){

            $recipesTitle = 'Recipes';

            if(isset($data['selCat']) && $data['selCat'] !== '0'){
                $selTitle= Category::where('id','=',$data['selCat'])
                                    ->select('name')
                                    ->get();
                foreach($selTitle as $title){
                    $recipesTitle .= ' '.$title['name'];
                }
            }

            if(isset($data['selArea']) && $data['selArea'] !== '0'){
                $selTitle = Area::where('id','=',$data['selArea'])
                                ->select('name')
                                ->get();
                foreach($selTitle as $title){
                    $recipesTitle .= ' '.$title['name'];
                }
            }

            if(isset($data['selTag']) && $data['selTag'] !== '0'){
                $selTitle = Tag::where('id','=',$data['selTag'])
                                ->select('name')
                                ->get();
                foreach($selTitle as $title){
                    $recipesTitle .= ' ' .$title['name'];
                }
            }

            if(isset($data['wordIngr'])){
                $selTitle = Ingredient::where('name','=',$data['wordIngr'])
                                        ->select('name')
                                        ->get();
                foreach($selTitle as $title){
                    $recipesTitle .= ' with '.$title['name'];
                }
            }

        }else{
            $recipesTitle = null;
        }

        return $recipesTitle;
    }

}