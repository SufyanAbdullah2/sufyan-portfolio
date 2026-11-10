<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#08090a">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>Admin sign in · Sufyan</title>
    @vite(['resources/css/app.css', 'resources/css/admin.css'])
</head>
<body class="admin-body admin-login-page">
    <main class="admin-login">
        <a class="admin-brand" href="{{ route('home') }}">SUFYAN<span>®</span><small>STUDIO</small></a>
        <span class="admin-eyebrow">A QUIET LITTLE CONTROL ROOM</span>
        <h1>Good to<br><em>see you.</em></h1>
        <p>Sign in to look after your projects and messages.</p>
        <form method="POST" action="{{ route('admin.login.store') }}" class="admin-form">
            @csrf
            <label for="email">EMAIL ADDRESS</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
            @error('email')<small class="admin-error">{{ $message }}</small>@enderror
            <label for="password">PASSWORD</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required>
            @error('password')<small class="admin-error">{{ $message }}</small>@enderror
            <label class="admin-remember"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button class="admin-button" type="submit">SIGN IN <span>↗</span></button>
        </form>
        <a class="admin-back" href="{{ route('home') }}">← Back to the portfolio</a>
    </main>
</body>
</html>
