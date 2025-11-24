<?php

namespace App\Repositories\Area;

interface AreaInterface
{
    public function updateOrInsert(array $data);

    public function listAreas();

    public function optionAreaSelected(array $data);

}