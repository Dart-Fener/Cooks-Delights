<?php

namespace App\Repositories\Rec_Ingr_Meas;

use App\Models\Rec_Ingr_Meas_ID;
use App\Repositories\Rec_Ingr_Meas\Rec_Ingr_MeasInterface;
use Illuminate\Support\Facades\Validator;

class Rec_Ingr_MeasEloquent implements Rec_Ingr_MeasInterface
{
    public function updateOrInsert(array $data)
    {
        $validation = Validator::make($data,[
            'recipe_id' => 'required|integer',
            'ingredient_id' => 'required|integer',
            'measure_id' => 'required|integer'
        ]);

        if($validation->fails()){
            return [
                'success' => false,
                'errors' => $validation->errors()
            ];
        }elseif($validation->passes()){
            return Rec_Ingr_Meas_ID::updateOrInsert($data);
        }
    }

}