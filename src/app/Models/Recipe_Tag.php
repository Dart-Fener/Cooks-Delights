<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe_Tag extends Model
{
    /**
    * The table associated with the model.
    * Whole the fields to insert or update into table
    * @var string
    */

    protected $table = 'recipe__tags';

    protected $fillable = [
        'recipe_id',
        'tag_id'
    ];

    //Get the recipe that owns the recipe_tag.
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

    //Get the tag that owns the recipe_tag.
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

}
