<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    /**
    * The table associated with the model.
    * The primary key associated with the table.
    * Whole the fields to insert or update into table
    * @var string
    */

    protected $table = 'recipes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'slug',
        'name',
        'instruction',
        'thumb',
        'category_id',
        'area_id'
    ];

    //Get the area that owns the recipe.
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    //Get the category that owns the recipe.
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    //Get the recipe_tag associated with the recipe.
    public function recipe_tag(): HasMany
    {
        return $this->hasMany(Recipe_Tag::class);
    }

    //Get the rec_ingr_meas_id associated with the recipe.
    public function rec_ingr_meas_id(): HasMany
    {
        return $this->hasMany(Rec_Ingr_Meas_ID::class);
    }

}
