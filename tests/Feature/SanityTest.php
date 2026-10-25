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
        $this->get('/')->assertStatus(200);

        $this->get('/up')
            ->assertStatus(200)
            ->assertSee('Le Nkang')
            ->assertSee('Application up')
            ->assertSee('HTTP request received.');
    }
}
