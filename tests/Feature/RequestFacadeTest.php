<?php

namespace Tests\Feature;

use Tests\TestCase;

class RequestFacadeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequestFacadeIsTestable()
    {
        $response = $this->get('/?name=ProActive');

        $response->assertSee('ProActive');
    }
}
