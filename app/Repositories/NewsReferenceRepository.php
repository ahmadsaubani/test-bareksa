<?php

namespace App\Repositories;

use App\Models\News;
use App\Models\NewsReference;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class NewsReferenceRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model(): string
    {
        return NewsReference::class;
    }

    public function removeRef(News $news): bool
    {
        $getAllRefs = NewsReference::where("ref_id", $news->id)
            ->where("ref_class", get_class($news))
            ->where("ref_model", $news->getTable())
            ->get();

        if (count($getAllRefs) >= 1) {
            foreach ($getAllRefs as $ref) {
                $ref->delete();
            }
        }

        return true;
    }


    public function updateOrCreate($data, $type = "tag_id")
    {

        return NewsReference::updateOrCreate(
            [
                "ref_id"    => $data["ref_id"],
                $type       => $data[$type]
            ],
            [
                "ref_id"    => $data["ref_id"],
                "ref_model" => $data["ref_model"],
                "ref_class" => $data["ref_class"],
                $type       => $data[$type]
            ]
        );
    }
}
