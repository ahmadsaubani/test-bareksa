<?php

namespace Tests\Feature;

use App\Repositories\NewsRepository;
use App\Repositories\TagsRepository;
use App\Repositories\TopicRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class NewsTest extends TestCase
{
    public function testCanCreateNews()
    {
        $tagRepo = new TagsRepository();
        $tag    = $tagRepo->getTagBySlug("belajar-investasi");

        $topicRepo = new TopicRepository();
        $topic      = $topicRepo->getTopicBySlug("investasi");

        $data = [
            "title"         => "test membuat news",
            "description"   => "lorem ipsum sit amet",
            "topic_id"      => $topic->uuid,
            "tag_id"        => $tag->uuid
        ];

        $response = $this->json('POST', '/api/v1/news/create', $data);

        $response->assertStatus(201);
    }

    public function testCanEditNewsWithChangeTopicAndTag()
    {
        $newsRepo = new NewsRepository();
        $news     = $newsRepo->getNewsBySlug("test-membuat-news");

        $tagRepo = new TagsRepository();
        $tag    = $tagRepo->getTagBySlug("bareksa-navigator");

        $topicRepo = new TopicRepository();
        $topic      = $topicRepo->getTopicBySlug("pasar-modal");

        $data = [
            "title"         => "test update news",
            "description"   => "lorem ipsum sit amet",
            "topic_id"      => $topic->uuid,
            "tag_id"        => $tag->uuid
        ];

        $response = $this->json('POST', '/api/v1/news/update/' . $news->uuid, $data);

        $response->assertStatus(200);
    }

    public function testCanGetAllTag()
    {
        $response = $this->get('/api/v1/news/populate');

        $response->assertStatus(200);
    }

    public function testCanGetAllTagWithParamStatusDraft()
    {
        $response = $this->get('/api/v1/news/populate?status=draft');

        $response->assertStatus(200);
    }

    public function testCanGetAllTagWithParamTag()
    {
        $response = $this->get('/api/v1/news/populate?tag=bareksa-navigator');

        $response->assertStatus(200);
    }

    public function testCanGetAllTagWithParamTopic()
    {
        $response = $this->get('/api/v1/news/populate?topic=investasi');

        $response->assertStatus(200);
    }

    public function testCanDeleteNews()
    {
        $newsRepo = new NewsRepository();
        $news     = $newsRepo->getNewsBySlug("test-update-news");

        $response = $this->json('DELETE', '/api/v1/news/delete/' . $news->uuid);

        $response->assertStatus(200);
    }

    public function testCanGetAllTagWithParamStatusDeleted()
    {
        $response = $this->get('/api/v1/news/populate?status=deleted');

        $response->assertStatus(200);
    }

    public function testCanPublishNews()
    {
        $newsRepo = new NewsRepository();
        $news     = $newsRepo->getNewsBySlug("generasi-sandwich-kamu-membiayai-biaya-hidup-atau-gaya-hidup");

        $response = $this->json('POST', '/api/v1/news/publish/' . $news->uuid);
        
        $response->assertStatus(200);

    }

    public function testCanGetAllTagWithParamStatusPublish()
    {
        $response = $this->get('/api/v1/news/populate?status=publish');

        $response->assertStatus(200);
    }
}
