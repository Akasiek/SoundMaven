<?php

namespace Tests\Feature\Http\Controllers;

class SearchControllerTest extends ControllerWithAuthTestCase
{
    protected static string $url = '/search';

    public function test_search(): void
    {
        $this->getJson(self::$url . '/?query=ghost')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'album' => ['*' => ['id', 'title', 'release_date', 'cover_image']],
                'artist' => ['*' => ['id', 'name']],
                'track' => ['*' => ['id', 'title']],
            ]]);
    }

    public function test_album_search(): void
    {
        $this->getJson(self::$url . '/?type=album&query=elephant')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['album' => ['*' => [
                'id', 'title', 'release_date', 'cover_image',
            ]]]]);
    }
}
