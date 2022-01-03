<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    public $type = 'tag';

    protected $availableIncludes = [];

    /**
     * @param Tag $model
     * @return array
     */
    public function transform(Tag $model): array
    {
        return [
            "id"                    => $model->uuid,
            "title"                 => $model->title,
            "slug"                  => $model->slug,
        ];
    }

//    public function includeItemType(Item $model)
//    {
//        $type = Type::find($model->type_id);
//
//        if (!empty($type)) {
//            return $this->item($type, new TypeTransformer(), "type");
//        }
//    }
}
