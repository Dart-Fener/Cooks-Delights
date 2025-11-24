<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    /**
    * The table associated with the model.
    * The primary key associated with the table.
    * Whole the fields to insert or update into table
    * @var string
    */

    protected $table = 'ingredients';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name'
    ];

    //Get the rec_ingr_meas_id associated with the ingredient.
    public function rec_ingr_meas_id(): HasMany
    {
        return $this->hasMany(Rec_Ingr_Meas_ID::class);
    }

}
