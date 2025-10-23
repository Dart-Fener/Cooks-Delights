<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
    * The table associated with the model.
    * The primary key associated with the table.
    * Whole the fields to insert or update into table
    * @var string
    */

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];
    
    //Get the recipe associated with the category.
    public function recipe(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

}
