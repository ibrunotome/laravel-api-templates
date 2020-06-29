<?php

namespace Tests\Feature;

use Tests\TestCase;

class UtilControllerTest extends TestCase
{
    public function testServerTime()
    {
        $this
            ->getJson(route('api.server.ping'))
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'meta',
            ]);
    }
}
