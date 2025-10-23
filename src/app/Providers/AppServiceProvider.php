<?php

namespace App\Providers;

use App\Repositories\Area\AreaInterface;
use App\Repositories\Area\AreaEloquent;
use App\Repositories\Category\CategoryEloquent;
use App\Repositories\Category\CategoryInterface;
use App\Repositories\Ingredient\IngredientEloquent;
use App\Repositories\Ingredient\IngredientInterface;
use App\Repositories\Measure\MeasureEloquent;
use App\Repositories\Measure\MeasureInterface;
use App\Repositories\Newsletter\NewsletterEloquent;
use App\Repositories\Newsletter\NewsletterInterface;
use App\Repositories\Rec_Ingr_Meas\Rec_Ingr_MeasEloquent;
use App\Repositories\Rec_Ingr_Meas\Rec_Ingr_MeasInterface;
use App\Repositories\Recipe\RecipeEloquent;
use App\Repositories\Recipe\RecipeInterface;
use App\Repositories\Recipe_Tag\Recipe_TagEloquent;
use App\Repositories\Recipe_Tag\Recipe_TagInterface;
use App\Repositories\Tag\TagEloquent;
use App\Repositories\Tag\TagInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AreaInterface::class, AreaEloquent::class);
        $this->app->bind(CategoryInterface::class,CategoryEloquent::class);
        $this->app->bind(IngredientInterface::class,IngredientEloquent::class);
        $this->app->bind(MeasureInterface::class,MeasureEloquent::class);
        $this->app->bind(NewsletterInterface::class,NewsletterEloquent::class);
        $this->app->bind(Rec_Ingr_MeasInterface::class,Rec_Ingr_MeasEloquent::class);
        $this->app->bind(RecipeInterface::class,RecipeEloquent::class);
        $this->app->bind(Recipe_TagInterface::class,Recipe_TagEloquent::class);
        $this->app->bind(TagInterface::class,TagEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
