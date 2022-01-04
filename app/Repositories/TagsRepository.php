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

    /**
     * @param $uuidTag
     *
     * @return mixed
     * @throws \Exception
     */
    public function getTagByUuid($uuidTag)
    {
        $data = $this->model->where("uuid", $uuidTag)->first();

        if (! $data) {
            throw new \Exception("data tidak ditemukan", 403);
        }

        return $data;
    }

    /**
     * @param string $tagSlug
     *
     * @return mixed
     */
    public function getTagBySlug(string $tagSlug)
    {
        return $this->model->where("slug", "LIKE", "%" . $tagSlug ."%")
            ->first();
    }
}

