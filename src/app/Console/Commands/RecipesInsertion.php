<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Ingredient\IngredientInterface;
use App\Repositories\Measure\MeasureInterface;
use App\Repositories\Rec_Ingr_Meas\Rec_Ingr_MeasInterface;
use App\Repositories\Recipe\RecipeInterface;
use App\Repositories\Recipe_Tag\Recipe_TagInterface;
use App\Repositories\Tag\TagInterface;
use App\Models\Category;
use App\Models\Area;
use App\Models\Tag;
use App\Models\Ingredient;
use App\Models\Measure;
use App\Models\Recipe;

class RecipesInsertion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cooksDelight:recipes-insertion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command of Data Recipes Insert into DB';

    /**
     * Execute the console command.
     */

    protected $area;
    protected $category;
    protected $ingredient;
    protected $measure;
    protected $rec_ingr_meas;
    protected $recipe;
    protected $recipe_tag;
    protected $tag;

    public function __construct(CategoryInterface $category,AreaInterface $area,IngredientInterface $ingredient,MeasureInterface $measure,Rec_Ingr_MeasInterface $rec_ingr_meas,RecipeInterface $recipe,Recipe_TagInterface $recipe_tag,TagInterface $tag) {

        parent::__construct();

        $this->area = $area;
        $this->category = $category;
        $this->ingredient = $ingredient;
        $this->measure = $measure;
        $this->rec_ingr_meas = $rec_ingr_meas;
        $this->recipe = $recipe;
        $this->recipe_tag = $recipe_tag;
        $this->tag = $tag;

    }
    public function handle()
    {
        //Use of Guzzle library for API request
        $client = new Client();
        
        function CountRecipes(){
            $recipesCount = Recipe::select('id')->count();
            return $recipesCount;
        }

        $this->comment("Initial total number of recipes into database:" . CountRecipes() . "\n");

        $recipesNum = $this->ask("Digits the total number of recipes (Max 301)");

        switch(true){
            case is_numeric($recipesNum) && $recipesNum > 0 && $recipesNum <= 301:
                do{
                    $numRecipesRequired = $recipesNum - CountRecipes();
                    
                    // This for loop of $i times the json Api for database data insert
                    for($i = 0;$i < $numRecipesRequired; $i++){

                        $response = $client->request('GET','https://www.themealdb.com/api/json/v1/1/random.php');
                        $json = json_decode($response->getBody());

                        foreach($json as $objArray){
                            foreach($objArray as $obj){
                                
                                $this->category->updateOrInsert([
                                    'name' => $obj->strCategory
                                ]);

                                $this->area->updateOrInsert([
                                    'name' => $obj->strArea
                                ]);
                                
                                //Add escape character \ at string
                                $instruction = addslashes(trim($obj->strInstructions));

                                $categ_id = Category::where('name','=',$obj->strCategory)
                                                    ->pluck('id')
                                                    ->first();
                                $area_id = Area::where('name','=',$obj->strArea)
                                                ->pluck('id')
                                                ->first();

                                $slug = str_replace(' ','-',$obj->strMeal);

                                $this->recipe->insertOrIgnore([
                                    'id' => $obj->idMeal,
                                    'slug' => strtolower($slug),
                                    'name' => $obj->strMeal,
                                    'instruction' => $instruction,
                                    'thumb' => $obj->strMealThumb,
                                    'category_id' => $categ_id,
                                    'area_id' => $area_id
                                ]);
                                                            
                                if(!empty($obj->strTags)){
                                    $tags = explode(',',$obj->strTags); //Split tags 
                                        
                                    foreach($tags as $tag){

                                        $this->tag->updateOrInsert([
                                            'name' => trim($tag)
                                        ]);

                                        $tag_id = Tag::where('name','=',$tag)
                                                    ->pluck('id')
                                                    ->first();

                                        $this->recipe_tag->updateOrInsert([
                                            'recipe_id' => $obj->idMeal,
                                            'tag_id' => $tag_id
                                        ]);

                                    }
                                }
                            
                                $ingrMeas = [
                                    ['ingredient' => ucwords($obj->strIngredient1), 'measure' => ucwords($obj->strMeasure1)],
                                    ['ingredient' => ucwords($obj->strIngredient2), 'measure' => ucwords($obj->strMeasure2)],
                                    ['ingredient' => ucwords($obj->strIngredient3), 'measure' => ucwords($obj->strMeasure3)],
                                    ['ingredient' => ucwords($obj->strIngredient4), 'measure' => ucwords($obj->strMeasure4)],
                                    ['ingredient' => ucwords($obj->strIngredient5), 'measure' => ucwords($obj->strMeasure5)],
                                    ['ingredient' => ucwords($obj->strIngredient6), 'measure' => ucwords($obj->strMeasure6)],
                                    ['ingredient' => ucwords($obj->strIngredient7), 'measure' => ucwords($obj->strMeasure7)],
                                    ['ingredient' => ucwords($obj->strIngredient8), 'measure' => ucwords($obj->strMeasure8)],
                                    ['ingredient' => ucwords($obj->strIngredient9), 'measure' => ucwords($obj->strMeasure9)],
                                    ['ingredient' => ucwords($obj->strIngredient10),'measure' => ucwords($obj->strMeasure10)],
                                    ['ingredient' => ucwords($obj->strIngredient11), 'measure' => ucwords($obj->strMeasure11)],
                                    ['ingredient' => ucwords($obj->strIngredient12), 'measure' => ucwords($obj->strMeasure12)],
                                    ['ingredient' => ucwords($obj->strIngredient13), 'measure' => ucwords($obj->strMeasure13)],
                                    ['ingredient' => ucwords($obj->strIngredient14), 'measure' => ucwords($obj->strMeasure14)],
                                    ['ingredient' => ucwords($obj->strIngredient15), 'measure' => ucwords($obj->strMeasure15)],
                                    ['ingredient' => ucwords($obj->strIngredient16), 'measure' => ucwords($obj->strMeasure16)],
                                    ['ingredient' => ucwords($obj->strIngredient17), 'measure' => ucwords($obj->strMeasure17)],
                                    ['ingredient' => ucwords($obj->strIngredient18), 'measure' => ucwords($obj->strMeasure18)],
                                    ['ingredient' => ucwords($obj->strIngredient19), 'measure' => ucwords($obj->strMeasure19)],
                                    ['ingredient' => ucwords($obj->strIngredient20), 'measure' => ucwords($obj->strMeasure20)]
                                ];
                            
                                foreach($ingrMeas as $value){

                                    if($value['ingredient'] && $value['measure']){

                                        $this->ingredient->updateOrInsert([
                                            'name' => $value['ingredient']
                                        ]);

                                        $this->measure->updateOrInsert([
                                            'name' => $value['measure']
                                        ]);

                                        $ingr_id = Ingredient::where('name','=',$value['ingredient'])
                                                            ->pluck('id')
                                                            ->first();
                                        
                                        $meas_id = Measure::where('name','=',$value['measure'])
                                                            ->pluck('id')
                                                            ->first();

                                        $this->rec_ingr_meas->updateOrInsert([
                                            'recipe_id' => $obj->idMeal,
                                            'ingredient_id' => $ingr_id,
                                            'measure_id' => $meas_id
                                        ]); 
                                    }
                                }
                            }
                        }
                    }
                }while($recipesNum > CountRecipes() && CountRecipes() !== $recipesNum);

                $this->comment( "\nFinal total number of recipes into database:" . CountRecipes() . "\n");
                break;
            case !is_numeric($recipesNum):
                $this->error("\n Please digit a numerical value \n");
                break;
            case $recipesNum < 1 || $recipesNum > 301:
                $this->error("\n Please digit a number between 1 and 301 \n");
                break;
            
        }
    }
}
