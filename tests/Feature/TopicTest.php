<?php

namespace Tests\Feature;

use App\Repositories\TopicRepository;
use Tests\TestCase;

class TopicTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanGetAllTopic()
    {
        $response = $this->get('/api/v1/topic/populate');

        $response->assertStatus(200);
    }

    public function testCanCreateTopic()
    {
        $response = $this->json('POST', '/api/v1/topic/create', [
            'title'  => 'testing membuat topic',
        ]);

        $response->assertStatus(201);
    }

    public function testCanEditTopic()
    {
        $topicRepo  = new TopicRepository();
        $topic      = $topicRepo->getTopicBySlug("testing-membuat-topic");

        $response = $this->json('POST', '/api/v1/topic/update/' . $topic->uuid, [
            'title'  => 'testing ubah topic',
        ]);

        $response->assertStatus(200);
    }

    public function testCanDeleteTopic()
    {
        $topicRepo  = new TopicRepository();
        $topic      = $topicRepo->getTopicBySlug("testing-ubah-topic");

        $response = $this->json('DELETE', '/api/v1/topic/delete/' . $topic->uuid);

        $response->assertStatus(200);
    }
}
