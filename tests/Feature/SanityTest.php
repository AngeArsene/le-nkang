<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanityTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_application_is_up_and_running(): void
    {
        $this->get('/')->assertOk();

        $this->get('/up')
            ->assertOk()
            ->assertSee('Le Nkang')
            ->assertSee('Application up')
            ->assertSee('HTTP request received.');
    }
}
