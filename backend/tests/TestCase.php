<?php

namespace Tests;

use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDB();
    }

    private function seedDB(): void
    {
        new TestSeeder()->run();
    }
}
