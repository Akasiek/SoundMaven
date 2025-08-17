<?php

namespace Tests\Feature\Http\Controllers;

class SearchControllerTest extends ControllerWithAuthTestCase
{
    static protected string $url = '/search';

    public function testSearch(): void
    {
        $this->getJson(self::$url . '/?query=ghost')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'album' => ['*' => ['id', 'title', 'release_date', 'cover_image']],
                'artist' => ['*' => ['id', 'name']],
                'track' => ['*' => ['id', 'title']],
            ]]);
    }

    public function testAlbumSearch(): void
    {
        $this->getJson(self::$url . '/?type=album&query=elephant')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['album' => ['*' => [
                'id', 'title', 'release_date', 'cover_image',
            ]]]]);
    }
}
