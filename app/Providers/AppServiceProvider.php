<?php

namespace App\Providers;

use App\ValueObjects\VisitorId;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(VisitorId::class, function (Application $app): VisitorId {
            $value = $app->make('request')->attributes->get('visitor_id');

            if (! is_string($value)) {
                throw new RuntimeException('No visitor ID on this request. Is AssignVisitorId running?');
            }

            return new VisitorId($value);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
