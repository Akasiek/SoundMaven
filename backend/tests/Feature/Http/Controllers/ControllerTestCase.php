<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class ControllerTestCase extends TestCase
{
    protected $defaultHeaders = [
        'Accept' => 'application/json',
    ];

    protected $withCredentials = true;
}

