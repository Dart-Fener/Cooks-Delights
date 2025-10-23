<?php

namespace App\Repositories\Newsletter;

use App\Models\Newsletter;
use App\Repositories\Newsletter\NewsletterInterface;
use Illuminate\Support\Facades\Validator;

class NewsletterEloquent implements NewsletterInterface
{
    public function create(array $data)
    {
        $validation = Validator::make($data,[
            'email' => 'required|string|max:255'
        ]);

        if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }elseif($validation->passes()){
            return Newsletter::create($data);
        }
    }

}