<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    /**
    * The table associated with the model.
    * The primary key associated with the table.
    * Whole the fields to insert or update into table
    * @var string
    */

    protected $table = 'newsletters';

    protected $primaryKey = 'id';

    protected $fillable = [
        'email'
    ];
    
}
