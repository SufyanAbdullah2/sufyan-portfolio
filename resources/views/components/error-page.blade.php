@props([
    'code',
    'eyebrow',
    'heading',
    'message',
])

<main class="error-page section-pad" aria-labelledby="error-heading">
    <div class="error-topline">
        <a class="brand" href="{{ route('home') }}">Sufyan<span>®</span></a>
        <span class="eyebrow">STATUS / {{ $code }}</span>
    </div>

    <div class="error-content">
        <div class="error-art" aria-hidden="true">
            <span class="error-orbit error-orbit-outer"></span>
            <span class="error-orbit error-orbit-inner"></span>
            <span class="error-code">{{ $code }}</span>
            <span class="error-spark">✳</span>
        </div>

        <div class="error-copy">
            <p class="eyebrow">{{ $eyebrow }}</p>
            <h1 id="error-heading">{{ $heading }}</h1>
            <p class="error-message">{{ $message }}</p>
            <div class="error-actions">
                <a class="error-home" href="{{ route('home') }}">BACK TO HOME <span aria-hidden="true">↗</span></a>
                <a class="error-contact" href="{{ route('home') }}#contact">NEED A HAND?</a>
            </div>
        </div>
    </div>

    <div class="error-bottom">
        <span class="eyebrow">SUFYAN® — CREATIVE DEVELOPER</span>
        <span class="eyebrow">A LITTLE DETOUR. NOTHING MORE.</span>
    </div>
</main>
