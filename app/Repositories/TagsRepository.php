<?php

namespace App\Repositories;

use App\Models\Tag;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class TagsRepository.
 */
class TagsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model(): string
    {
        return Tag::class;
    }
}
