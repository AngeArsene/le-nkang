<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

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

    public function visit(...$args)
    {
        parent::visit(...$args);

        return $this->delay() > 0 ? $this->pause($this->delay()) : $this;
    }

    public function click(...$args)
    {
        parent::click(...$args);

        return $this->delay() > 0 ? $this->pause($this->delay()) : $this;
    }
}
