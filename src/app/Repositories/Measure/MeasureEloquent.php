<?php

namespace App\Repositories\Measure;

use App\Models\Measure;
use App\Repositories\Measure\MeasureInterface;
use Illuminate\Support\Facades\Validator;

class MeasureEloquent implements MeasureInterface
{
    public function updateOrInsert(array $data)
    {
        $validation = Validator::make($data,[
            'name' => 'required|string|max:255'
        ]);

        if($validation->fails()){
            return [
                'success' => false,
                'errors' => $validation->errors()
            ];
        }elseif($validation->passes()){
            return Measure::updateOrInsert($data);
        }
    }

}