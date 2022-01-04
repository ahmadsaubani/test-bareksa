<?php

namespace App\Repositories;

use App\Models\News;
use App\Models\NewsReference;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Nyholm\Psr7\Request;

class NewsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model(): string
    {
        return News::class;
    }

    /**
     * @param $uuidNews
     *
     * @return mixed
     * @throws \Exception
     */
    public function getNewsByUuid($uuidNews)
    {
        $data = $this->model->where("uuid", $uuidNews)->first();

        if (! $data) {
            throw new \Exception("data tidak ditemukan", 403);
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function savingNews(array $data)
    {
        return News::updateOrCreate(
            [
                "slug"          => $data["slug"],
                "topic_id"      => $data["topic_id"]
            ],
            [
                "slug"          => $data["slug"],
                "title"         => $data["title"],
                "topic_id"      => $data["topic_id"],
                "description"   => $data["description"]
            ]
        );
    }

    /**
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function createNews(array $data)
    {
        if (array_key_exists("topic_id", $data) && $data["topic_id"] != null) {
            $topicObject        = $this->getTopicObject($data["topic_id"]);
            $data["topic_id"]   = $topicObject->id;
        }

        $creating = $this->savingNews($data);

        if (array_key_exists("tag_id", $data) && $data["tag_id"] != null) {
            $explodeTags         = explode(",", $data["tag_id"]);

            foreach ($explodeTags as $tag) {
                $tagReference       = new TagsRepository();
                $objectTag          = $tagReference->getTagByUuid(trim($tag));

                if (! $objectTag) {
                    throw new \Exception("Tag dengan UUID ". $tag . " tidak ditemukan.", 403);
                }

                $addTagReferences   = new NewsReferenceRepository();
                $parsingArray = [
                    "ref_id"    => $creating->id,
                    "ref_model" => $creating->getTable(),
                    "ref_class" => get_class($creating),
                    "tag_id"    => $objectTag->id
                ];

                $addTagReferences->updateOrCreate($parsingArray);
            }
        }

        return $creating;
    }

    /**
     * @param News $news
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function updateNews(News $news, array $data)
    {
        if (array_key_exists("topic_id", $data) && $data["topic_id"] != null) {
            $topicObject        = $this->getTopicObject($data["topic_id"]);
            $data["topic_id"]   = $topicObject->id;
        } else {
            $data["topic_id"]   = $news->topic_id;
        }

        $updating = $this->savingNews($data);

        if (array_key_exists("tag_id", $data) && $data["tag_id"] != null) {
            $addTagReferences   = new NewsReferenceRepository();
            $addTagReferences->removeRef($updating);

            $explodeTags         = explode(",", $data["tag_id"]);

            foreach ($explodeTags as $tag) {
                $tagReference       = new TagsRepository();
                $objectTag          = $tagReference->getTagByUuid(trim($tag));

                if (! $objectTag) {
                    throw new \Exception("Tag dengan UUID ". $tag . " tidak ditemukan.", 403);
                }

                $parsingArray = [
                    "ref_id"    => $updating->id,
                    "ref_model" => $updating->getTable(),
                    "ref_class" => get_class($updating),
                    "tag_id"    => $objectTag->id
                ];

                $addTagReferences->updateOrCreate($parsingArray, "tag_id");
            }
        }

        return $updating;
    }

    /**
     * @throws \Exception
     */
    public function getTopicObject($uuidTopic)
    {
        $topic  = new TopicRepository();

        return $topic->getTopicByUuid($uuidTopic);
    }

    /**
     * @param News $news
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteNews(News $news): ?bool
    {
        return $news->delete();
    }

    /**
     * @throws \Exception
     */
    public function filter($param): \Illuminate\Database\Eloquent\Builder
    {
        if (@$param["topic"] != null && @$param["tag"] != null) {
            throw new \Exception("maaf, pencarian menggunakan topic dan tag tidak dapat digunakan secara bersamaan.", 403);
        }

        $news = $this->model->newQuery();

        if (array_key_exists("status", $param) && @$param["status"] != null) {
            switch (@$param["status"]) {
                case @$param["status"] == News::STATUS_DRAFT:
                    $news->where("status", 1);
                    break;
                case @$param["status"] == News::STATUS_DELETED;
                    $news->where("status", 2);
                    break;
                case @$param["status"] == News::STATUS_PUBLISHED;
                    $news->where("status", 3);
                    break;
            }

        }

        if (array_key_exists("topic", $param) && @$param["topic"] != null) {
            $topicRepository = new TopicRepository();
            $topic           = $topicRepository->getTopicBySlug(@$param["topic"]);

            if (! $topic) {
                throw new \Exception("maaf, topic tidak ditemukan.", 403);
            }

            $news->where("topic_id", $topic->id);
        }

        if (array_key_exists("tag", $param) && @$param["tag"] != null) {
            $tagRepository  = new TagsRepository();
            $tag            = $tagRepository->getTagBySlug(@$param["tag"]);

            if (! $tag) {
                throw new \Exception("maaf, tag tidak ditemukan.", 403);
            }

            $refRepository  = new NewsReference();
            $allTagRelated  = $refRepository->newQuery()->whereIn("tag_id", [$tag->id])
                ->get()
                ->pluck("ref_id")
                ->toArray();

            $news->whereIn("id", $allTagRelated);
        }

        return $news;
    }
}
