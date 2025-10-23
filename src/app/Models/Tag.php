<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    /**
    * The table associated with the model.
    * The primary key associated with the table.
    * Whole the fields to insert or update into table
    * @var string
    */

    protected $table = 'tags';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    //Get the recipe_tag associated with the tag.
    public function recipe_tag(): HasMany
    {
        return $this->hasMany(Recipe_Tag::class);
    }

}
