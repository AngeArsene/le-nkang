<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Verifies the application health endpoints return the expected content.
 */
class SanityTest extends TestCase
{
    /**
     * Confirms the home page and health endpoint respond successfully with expected status content.
     */
    public function testApplicationIsUpAndRunning(): void
    {
        $this->get('/')->assertOk();

        $this->get('/up')
            ->assertOk()
            ->assertSee('Le Nkang')
            ->assertSee('Application up')
            ->assertSee('HTTP request received.');
    }
}
