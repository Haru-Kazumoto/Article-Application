<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TagsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TagsRepository implements TagsRepositoryInterface
{
    public function getAllTags()
    {
        return DB::table('tags')->get();
    }
}