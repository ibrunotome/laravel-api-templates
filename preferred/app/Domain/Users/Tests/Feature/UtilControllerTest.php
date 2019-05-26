<?php

namespace Preferred\Domain\Users\Tests\Feature;

use Tests\TestCase;

class UtilControllerTest extends TestCase
{
    public function testServerTime()
    {
        $this
            ->getJson(route('api.server.ping'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
                'meta',
            ]);
    }
}
