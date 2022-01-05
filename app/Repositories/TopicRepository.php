<?php

namespace App\Repositories;

use App\Models\Topic;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class TopicRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model(): string
    {
        return Topic::class;
    }


    /**
     * @param $uuidTopic
     *
     * @return mixed
     * @throws \Exception
     */
    public function getTopicByUuid($uuidTopic)
    {
        $data = $this->model->where("uuid", $uuidTopic)->first();

        if (! $data) {
            throw new \Exception("data tidak ditemukan", 403);
        }

        return $data;
    }


    /**
     * @param string $topicSlug
     *
     * @return mixed
     */
    public function getTopicBySlug(string $topicSlug)
    {
        $getCache = getCache($topicSlug);
        if (! $getCache) {
            $data = $this->model->where("slug", "LIKE", "%" . $topicSlug ."%")
                ->first();
            setCache($topicSlug, $data);
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
        $key = "getAllTopic";
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
