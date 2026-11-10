<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#08090a">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="canonical" href="{{ rtrim((string) config('app.url'), '/') }}/">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="description" content="Sufyan — Laravel developer and creative full-stack developer building thoughtful digital experiences.">
    <meta property="og:title" content="Sufyan® — Creative Developer">
    <meta property="og:description" content="I build digital experiences with clarity, character and code.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ rtrim((string) config('app.url'), '/') }}/">
    <meta name="twitter:card" content="summary">
    <title>@yield('title', 'Sufyan® — Creative Developer')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="site-noise" aria-hidden="true"></div>
    @yield('content')
</body>
</html>
