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
        deleteCache("getAllTag");
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
        $getCache = getCache($tagSlug);
        if (! $getCache) {
            $data = $this->model->where("slug", "LIKE", "%" . $tagSlug ."%")
                ->first();
            setCache($tagSlug, $data);
        } else {
            $temp=[];
            $test= json_decode($getCache, false);
            foreach ($test as $key => $value) {
                $temp[0][$key] = $value;
            }
            $data = $this->model::hydrate($temp);
            $data = $data[0];
        }
        return $data;
    }

    public function getData()
    {
        $key = "getAllTag";
        $getCache = getCache($key);

        if (! $getCache) {
            $data = $this->model::get();
            setCache($key, $data);
        } else {
            $data = $this->getFromCache($key);
        }

        return $data;

    }

    public function getFromCache(string $key)
    {
        return $this->model::hydrate(json_decode(getCache($key), false));
    }
}

