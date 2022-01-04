<?php

namespace App\Transformers;

use App\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    public $type = 'topic';

    protected $availableIncludes = [];

    /**
     * @param Topic $model
     * @return array
     */
    public function transform(Topic $model): array
    {
        return [
            "id"                    => $model->uuid,
            "title"                 => $model->title,
            "slug"                  => $model->slug,
        ];
    }

}
