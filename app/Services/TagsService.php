<?php

namespace App\Services;

use App\Repositories\Interfaces\TagsRepositoryInterface;

class TagsService
{
    private TagsRepositoryInterface $tagsRepository;

    public function __construct(TagsRepositoryInterface $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    public function getAllTags()
    {
        return $this->tagsRepository->getAllTags();
    }
}