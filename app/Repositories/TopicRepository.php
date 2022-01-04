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
}
