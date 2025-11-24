<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rec_Ingr_Meas_ID extends Model
{
    /**
    * The table associated with the model.
    * Whole the fields to insert or update into table
    * @var string
    */

    protected $table = 'rec__ingr__meas__i_d_s';

    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'measure_id'
    ];

    //Get the ingredient that owns the rec_ingr_meas_id.
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }

    //Get the measure that owns the rec_ingr_meas_id.
    public function measure(): BelongsTo
    {
        return $this->belongsTo(Measure::class);
    }

    //Get the recipe that owns the rec_ingr_meas_id.
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }

}
