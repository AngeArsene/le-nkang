<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class Main extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generate the page title based on the current route name.
     *
     * @return string The formatted page title with app name appended
     */
    public function pageTitle(): string
    {
        $title = Str::of(Route::currentRouteName())
            ->replace(['.', '-'], ' ')
            ->replace('index', 'feed', false)
            ->title();

        return $title.' - '.config('app.name');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.main');
    }
}
