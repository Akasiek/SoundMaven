<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Tests\TestCase;

class ControllerWithAuthTestCase extends TestCase
{
    protected $defaultHeaders = [
        'Accept' => 'application/json',
    ];

    protected $withCredentials = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }
}

