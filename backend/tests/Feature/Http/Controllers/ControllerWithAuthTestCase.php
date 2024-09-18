<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerWithAuthTestCase extends TestCase
{
    use RefreshDatabase;

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

