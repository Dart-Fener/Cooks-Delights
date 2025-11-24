<?php

namespace App\Repositories\Recipe_Tag;

use App\Models\Recipe_Tag;
use App\Repositories\Recipe_Tag\Recipe_TagInterface;
use Illuminate\Support\Facades\Validator;

class Recipe_TagEloquent implements Recipe_TagInterface
{
    public function updateOrInsert(array $data)
    {
        $validation = Validator::make($data,[
            'recipe_id' => 'required|integer',
            'tag_id' => 'required|integer'
        ]);

        if($validation->fails()){
            return [
                'success' => false,
                'errors' => $validation->errors()
            ];
        }elseif($validation->passes()){
            return Recipe_Tag::updateOrInsert($data);
        }
    }

}