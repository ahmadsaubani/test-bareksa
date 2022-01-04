<?php

namespace App\Transformers;

use App\Models\News;
use App\Models\NewsReference;
use App\Models\Tag;
use App\Repositories\TagsRepository;
use App\Repositories\TopicRepository;
use League\Fractal\TransformerAbstract;

class NewsTransformer extends TransformerAbstract
{
    public $type = 'news';

    protected $availableIncludes = ['topic', 'tags'];

    /**
     * @param News $model
     * @return array
     */
    public function transform(News $model): array
    {
        return [
            "id"                    => $model->uuid,
            "title"                 => $model->title,
            "slug"                  => $model->slug,
            "description"           => $model->description
        ];
    }

    public function includeTopic(News $model)
    {
        $topicRepository = new TopicRepository();
        $topic           = $topicRepository->getById($model->topic_id);

        if (!empty($topic)) {
            return $this->item($topic, new TopicTransformer(), "topic");
        }
    }

    public function includeTags(News $model)
    {
        $refRepository         = new NewsReference();
        $getValueFromNewsRef    = $refRepository->newQuery()->where("ref_id", $model->id)
            ->where("ref_class", get_class($model))
            ->where("ref_model", $model->getTable())
            ->get()
            ->pluck("tag_id")
            ->toArray();

        $tagRepository = new TagsRepository();
        $tags          = $tagRepository->whereIn("id", $getValueFromNewsRef)->get();

        if (!empty($tags)) {
            return $this->collection($tags, new TagTransformer(), "tags");
        }
    }
}

