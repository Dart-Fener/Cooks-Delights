<?php

namespace App\Repositories\Tag;

interface TagInterface
{
    public function updateOrInsert(array $data);

    public function listTags();

    public function optionTagsSelected(array $data);

}