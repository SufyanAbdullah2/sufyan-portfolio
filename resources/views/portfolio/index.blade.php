@extends('layouts.app')

@section('title', 'Sufyan® — Creative Developer')

@section('content')
<header class="nav-wrap">
    <a class="brand" href="#top" aria-label="Sufyan home">SUFYAN<span>®</span></a>
    <div class="nav-availability"><span class="status-dot"></span><span>OPEN TO GOOD PROJECTS</span><i></i><span>KARACHI, PK</span></div>
    <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-menu">
        <span class="menu-toggle-label">MENU</span><span class="menu-icon"><i></i><i></i></span>
    </button>
    <nav class="site-menu" id="site-menu" aria-label="Main navigation">
        <a href="#work">WORK <sup>01</sup></a>
        <a href="#about">ABOUT <sup>02</sup></a>
        <a href="#services">SERVICES <sup>03</sup></a>
        <a href="#contact">CONTACT <sup>04</sup></a>
        <div class="menu-bottom"><span>OPEN TO GOOD PROJECTS</span><span>KARACHI, PK · {{ now()->format('Y') }}</span></div>
    </nav>
</header>

<main id="top">
    <div class="scroll-progress" aria-hidden="true"></div>
    <section class="hero section-pad">
        <div class="hero-meta">
            <span class="eyebrow"><span class="status-dot"></span> A DEVELOPER WHO CARES ABOUT THE DETAILS</span>
            <span class="hero-location eyebrow">KARACHI, PAKISTAN <span>↘</span></span>
        </div>
        <div class="hero-stage">
            <div class="hero-title-wrap">
                <p class="hero-kicker reveal"><span class="hero-hello">Hey, I’m Sufyan.</span><span class="hero-kicker-note">Nice to have you here.</span></p>
                <h1 class="hero-title"><span class="line"><span>I build</span></span><span class="line line-indent"><span>the web</span></span><span class="line"><span>with <em>feeling.</em></span></span></h1>
                <p class="hero-lede reveal">I make websites that do more than work — they welcome you in, tell a story and make the little details count.</p>
                <div class="hero-actions reveal">
                    <a class="hero-cta hero-cta-primary" href="#work">SEE WHAT I’VE MADE <span>↘</span></a>
                    <a class="hero-cta hero-cta-secondary" href="#contact">SAY HELLO <span>↗</span></a>
                </div>
            </div>
            <aside class="hero-art reveal" aria-label="Selected project previews">
                <div class="hero-art-grid" aria-hidden="true"></div>
                <div class="hero-art-top"><span>A COUPLE OF THINGS I’VE MADE</span><span>01 — 02</span></div>
                <span class="hero-art-word" aria-hidden="true">MADE<br>WITH CARE</span>
                <figure class="hero-preview hero-preview--studio">
                    <img src="{{ asset('images/projects/studiova-services-img-1.jpg') }}" alt="" fetchpriority="high">
                    <figcaption><span>A LITTLE DIGITAL STUDIO</span><strong>STUDIOVA</strong></figcaption>
                </figure>
                <figure class="hero-preview hero-preview--lagunitas">
                    <img src="{{ asset('images/projects/lagunitas-can.png') }}" alt="" loading="lazy" decoding="async">
                    <figcaption><span>A PLAYFUL BRAND CONCEPT</span><strong>LAGUNITAS IPA</strong></figcaption>
                </figure>
                <span class="hero-sticker" aria-hidden="true"><b>MADE WITH<br>A LITTLE<br>EXTRA CARE</b><i>✳</i></span>
                <div class="hero-art-foot"><span>DESIGNED & BUILT BY SUFYAN</span><b>FROM KARACHI, WITH CARE</b></div>
            </aside>
        </div>
        <div class="hero-bottom">
            <p class="hero-copy reveal">A LITTLE CURIOSITY.<br>A LOT OF CARE.</p>
            <a class="round-link" href="#work" aria-label="Scroll to selected work"><span>SCROLL<br>TO EXPLORE</span><b>↘</b></a>
            <div class="hero-index"><span>MADE IN KARACHI</span><strong>ALWAYS<br>MAKING THINGS<span> / PK</span></strong></div>
        </div>
        <span class="hero-side-note" aria-hidden="true">INDEPENDENT THINKING. INTENTIONAL BUILDING.</span>
    </section>

    <section class="ticker" aria-label="Specialties">
        <div class="ticker-track"><span>MADE WITH CARE</span><b>✳</b><span>BUILT TO FEEL RIGHT</span><b>✳</b><span>GOOD DETAILS MATTER</span><b>✳</b><span>MADE WITH CARE</span><b>✳</b></div>
    </section>

    <section class="work section-pad" id="work">
        <div class="section-heading reveal">
            <div><span class="eyebrow">01 / A FEW THINGS I’VE MADE</span><h2>Made to<br><em>matter.</em></h2></div>
            <div class="work-intro">
                <p>From a playful beer concept to a digital studio, each project gave me a chance to make something with its own personality.</p>
                <div class="work-count"><span>MADE SO FAR</span><strong>{{ str_pad((string) $projects->count(), 2, '0', STR_PAD_LEFT) }} <i>projects</i></strong></div>
            </div>
        </div>
        <div class="project-grid">
            @forelse($projects as $index => $project)
                <article class="project-card project-card--{{ \Illuminate\Support\Str::slug($project->title) }} reveal">
                    @if($project->project_url)
                        <a class="project-image project-image--{{ \Illuminate\Support\Str::slug($project->title) }}" href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" aria-label="Visit {{ $project->title }} project">
                    @else
                        <div class="project-image project-image--{{ \Illuminate\Support\Str::slug($project->title) }}">
                    @endif
                        <span class="project-number">A LITTLE PROJECT <i>· 0{{ $index + 1 }}</i></span>
                        @if($project->image_url)
                            <img src="{{ str_starts_with($project->image_url, '/') ? asset(ltrim($project->image_url, '/')) : $project->image_url }}" alt="{{ $project->title }} project preview" loading="lazy" decoding="async">
                        @else
                            <div class="project-placeholder"><span>{{ $project->title }}</span></div>
                        @endif
                        @if($project->title === 'STUDIOVA')
                            <span class="project-client-mark"><img src="{{ asset('images/projects/studiova-logo-dark.svg') }}" alt="Studiova"></span>
                        @endif
                        <span class="project-image-title">{{ $project->title }}</span>
                        @if($project->project_url)<span class="project-arrow" aria-hidden="true">↗</span>@endif
                    @if($project->project_url)
                        </a>
                    @else
                        </div>
                    @endif
                    <div class="project-info">
                        <div><span class="eyebrow">{{ $project->category }}</span><h3>{{ $project->title }}</h3></div>
                        <span class="project-year">{{ $project->year }}</span>
                    </div>
                    <p class="project-description">{{ $project->description }}</p>
                    <div class="project-tech" aria-label="{{ $project->title }} technologies">
                        @if($project->title === 'LAGUNITAS IPA')
                            @foreach(['HTML / CSS', 'GSAP', 'SCROLLTRIGGER'] as $technology)
                                <span>{{ $technology }}</span>
                            @endforeach
                        @elseif($project->title === 'STUDIOVA')
                            @foreach(['LARAVEL', 'PHP / MYSQL', 'BLADE'] as $technology)
                                <span>{{ $technology }}</span>
                            @endforeach
                        @endif
                    </div>
                </article>
            @empty
                <p class="empty-state">Projects are being curated. Check back soon.</p>
            @endforelse
        </div>
    </section>

    <section class="about section-pad" id="about">
        <div class="section-heading reveal">
            <span class="eyebrow">02 / THE PERSON BEHIND THE PIXELS</span>
            <span class="about-stamp">GOOD THINGS<br>TAKE CARE <b>✳</b></span>
        </div>
        <div class="about-layout">
            <h2 class="about-statement reveal">I care about<br>how it <em>works.</em><br>and how it<br>makes you <em>feel.</em></h2>
            <div class="about-detail reveal">
                <p class="large-copy">I’m Sufyan, a developer from Karachi who loves turning a rough idea into a real thing people can use.</p>
                <p>I enjoy both sides of the screen: finding the look and feel, then building the Laravel and front-end pieces that make it work. The tiny details are usually my favourite part.</p>
                <a class="text-link" href="#contact">TELL ME WHAT YOU’RE THINKING <span>↗</span></a>
            </div>
        </div>
        <div class="stats-row">
            <div><strong>KARACHI</strong><span>WHERE I CALL HOME</span></div>
            <div><strong>DETAILS</strong><span>THE LITTLE THINGS MATTER</span></div>
            <div><strong>CURIOUS</strong><span>ALWAYS LEARNING, ALWAYS MAKING</span></div>
        </div>
    </section>

    <section class="stack section-pad">
        <div class="section-heading reveal">
            <div><span class="eyebrow">03 / THINGS I LIKE WORKING WITH</span><h2>My little<br><em>toolbox.</em></h2></div>
            <p>Tools are just tools. What matters is picking the ones that help an idea become something useful, lovely and real.</p>
        </div>
        <div class="stack-list">
            @foreach([['01','Backend','Laravel · PHP · MySQL'],['02','Frontend','HTML · CSS · JavaScript'],['03','Motion','GSAP · ScrollTrigger'],['04','Workflow','Git · GitHub · Vite']] as $item)
                <div class="stack-item reveal"><span>{{ $item[0] }}</span><h3>{{ $item[1] }}</h3><p>{{ $item[2] }}</p><b>↗</b></div>
            @endforeach
        </div>
    </section>

    <section class="services section-pad" id="services">
        <div class="section-heading reveal"><div><span class="eyebrow">04 / WAYS I CAN HELP</span><h2>Let’s make<br><em>it real.</em></h2></div></div>
        <div class="services-grid">
            <article class="service-card reveal"><span>01</span><div class="service-symbol">⌘</div><h3>Websites that work</h3><p>From a simple page to a full site, I build for real people, real screens and the everyday details.</p></article>
            <article class="service-card reveal"><span>02</span><div class="service-symbol">✳</div><h3>Front ends with feeling</h3><p>Thoughtful colours, type and small interactions that make a site feel like it belongs to you.</p></article>
            <article class="service-card reveal"><span>03</span><div class="service-symbol">⌁</div><h3>Laravel, done right</h3><p>Useful features and dependable backends, built carefully so everything works behind the scenes.</p></article>
        </div>
    </section>

    <section class="contact section-pad" id="contact">
        <div class="contact-top"><span class="eyebrow">05 / GOT SOMETHING ON YOUR MIND?</span><span class="eyebrow">MY INBOX IS OPEN <i>✳</i></span></div>
        <h2 class="contact-title reveal">Tell me<br>what you’re<br><em>dreaming up.</em><span class="contact-spark">✳</span></h2>
        <div class="contact-layout">
            <div class="contact-intro reveal"><p>Big plan, small question, half-formed idea — I’d genuinely love to hear about it. Leave me a note and I’ll get back to you.</p><a class="email-link" href="#contact-form">WRITE ME A LITTLE NOTE <span>↘</span></a></div>
            <form class="contact-form reveal" id="contact-form" action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="hp-field" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
                <label for="name">WHAT SHOULD I CALL YOU?</label><input id="name" name="name" value="{{ old('name') }}" required maxlength="100" placeholder="Your name">
                @error('name')<small class="field-error">{{ $message }}</small>@enderror
                <label for="email">WHERE CAN I REPLY?</label><input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="150" placeholder="you@example.com">
                @error('email')<small class="field-error">{{ $message }}</small>@enderror
                <label for="subject">WHAT’S IT ABOUT? <span>(OPTIONAL)</span></label><input id="subject" name="subject" value="{{ old('subject') }}" maxlength="150" placeholder="A project, a question, anything">
                <label for="message">YOUR NOTE</label><textarea id="message" name="message" rows="4" required minlength="10" maxlength="5000" placeholder="No need to have it all figured out...">{{ old('message') }}</textarea>
                @error('message')<small class="field-error">{{ $message }}</small>@enderror
                <button class="submit-button" type="submit"><span>SEND IT MY WAY</span><b>↗</b></button>
                @if(session('contact_success'))<p class="form-success" role="status">{{ session('contact_success') }}</p>@endif
                @if($errors->any())<p class="field-error" role="alert">Please review the highlighted fields and try again.</p>@endif
            </form>
        </div>
    </section>
</main>

<footer class="footer section-pad">
    <div class="footer-top"><a class="brand" href="#top">SUFYAN<span>®</span></a><span class="eyebrow">MADE SLOWLY, WITH CARE.</span><a class="back-top" href="#top">TAKE ME UP ↑</a></div>
    <div class="footer-word">THANKS FOR<br><span>BEING HERE.</span><i class="footer-doodle" aria-hidden="true">✳</i></div>
    <div class="footer-bottom"><span>© {{ now()->year }} SUFYAN · MADE IN KARACHI</span><div><a href="#work">HAVE A LOOK ↗</a><a href="#contact-form">SAY HELLO ↗</a></div><span>HOPE SOMETHING MADE YOU SMILE</span></div>
</footer>
@endsection
