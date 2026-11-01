<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', __('announcements.brand_name', [], 'fr'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/css/announcements/show.css',
            'resources/js/announcements/show.js',
        ])
    @endonce

    @stack('head')
</head>
<body>
    <a class="skip-link" href="#main-content">{{ __('announcements.skip_to_content', [], 'fr') }}</a>

    @yield('content')
</body>
</html>
