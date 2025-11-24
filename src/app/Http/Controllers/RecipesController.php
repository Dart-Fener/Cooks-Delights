<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Recipe\RecipeInterface;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Tag\TagInterface;
use App\Repositories\Ingredient\IngredientInterface;

class RecipesController extends Controller
{
    private $category;
    private $area;
    private $tag;
    private $ingredient;
    private $recipe;
    public function __construct(CategoryInterface $category,AreaInterface $area,TagInterface $tag,RecipeInterface $recipe,IngredientInterface $ingredient)
    {
        $this->category = $category;
        $this->area = $area;
        $this->tag = $tag;
        $this->ingredient = $ingredient;
        $this->recipe = $recipe;
    }
    public function index()
    {
        $randomCards = $this->recipe->randomCards();

        return view('home',compact('randomCards'));
    }

    public function palettes()
    {
        $categories = $this->category->listCategories();
        $areas = $this->area->listAreas();
        $tags = $this->tag->listTags();

        return view('palettes',compact('areas','categories','tags'));
    }

    public function recipeDetailes(Request $request){

        $slug = $request->slug;

        $recipeList = $this->recipe->recipeDetailes($slug);

        return view('recipes-detailes',compact('recipeList'));
    }

    public function recipesIndex()
    {
        $categories = $this->category->listCategories();
        $areas = $this->area->listAreas();
        $tags = $this->tag->listTags();

        return view('recipes',compact('categories','areas','tags'));
    }

    public function recipesRequest(Request $request)
    {
        $data = $request->all();

        $selectedCat = $this->category->optionCategoriesSelected($data);
        $selectedArea = $this->area->optionAreaSelected($data);
        $selectedTag = $this->tag->optionTagsSelected($data);
        $inputTxtIngr = $this->ingredient->listIngredients($data);
        $selectedOptTitle = $this->recipe->cardsTitle($data);
        $recipesList = $this->recipe->listRecipes($data);

        return response()->json([
            'message' => 'success',
            'title' => $selectedOptTitle,
            'categories' => $selectedCat,
            'areas' => $selectedArea,
            'tags' => $selectedTag,
            'ingredients' => $inputTxtIngr,
            'cards' => $recipesList
        ]);
    }

    public function aboutUs()
    {
        return view('about-us');
    }
}
