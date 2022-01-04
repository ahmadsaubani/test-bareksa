<?php

namespace Tests\Feature;

use App\Repositories\TagsRepository;
use Tests\TestCase;

class TagTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanGetAllTag()
    {
        $response = $this->get('/api/v1/tags/populate');

        $response->assertStatus(200);
    }

    public function testCanCreateTag()
    {
        $response = $this->json('POST', '/api/v1/tags/create', [
            'title'  => 'testing membuat tag',
        ]);

        $response->assertStatus(201);
    }

    public function testCanEditTag()
    {
        $tagRepo = new TagsRepository();
        $tag     = $tagRepo->getTagBySlug("testing-membuat-tag");

        $response = $this->json('POST', '/api/v1/tags/update/' . $tag->uuid, [
            'title'  => 'testing ubah tag',
        ]);

        $response->assertStatus(200);
    }

    public function testCanDeleteTag()
    {
        $tagRepo = new TagsRepository();
        $tag     = $tagRepo->getTagBySlug("testing-ubah-tag");

        $response = $this->json('DELETE', '/api/v1/tags/delete/' . $tag->uuid);

        $response->assertStatus(200);
    }
}
