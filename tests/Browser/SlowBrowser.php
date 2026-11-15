<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

/**
 * Browser wrapper that pauses briefly after navigation and clicks.
 */
class SlowBrowser extends Browser
{
    private const DEFAULT_DELAY_MS = 5000;

    /**
     * Delay in milliseconds applied after every visit and click.
     */
    protected function delay(): int
    {
        return self::DEFAULT_DELAY_MS;
    }

    /**
     * Visit the given URL and pause briefly so the page settles.
     *
     * @param  mixed  ...$args
     */
    public function visit(...$args)
    {
        parent::visit(...$args);

        return $this->delay() > 0 ? $this->pause($this->delay()) : $this;
    }

    /**
     * Click an element and pause briefly after the interaction.
     *
     * @param  mixed  ...$args
     */
    public function click(...$args)
    {
        parent::click(...$args);

        return $this->delay() > 0 ? $this->pause($this->delay()) : $this;
    }
}
