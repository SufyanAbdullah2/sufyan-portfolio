<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#08090a">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title') · Sufyan Admin</title>
    @vite(['resources/css/app.css', 'resources/css/admin.css'])
</head>
<body class="admin-body">
    <header class="admin-topbar">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}">SUFYAN<span>®</span><small>STUDIO</small></a>
        <nav class="admin-nav" aria-label="Admin navigation">
            <a href="{{ route('admin.dashboard') }}">Overview</a>
            <a href="{{ route('admin.projects.index') }}">Projects</a>
            <a href="{{ route('admin.messages.index') }}">Messages</a>
        </nav>
        <div class="admin-account">
            <span>{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Sign out ↗</button>
            </form>
        </div>
    </header>
    <main class="admin-main">
        @if (session('status'))
            <div class="admin-flash" role="status">{{ session('status') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
