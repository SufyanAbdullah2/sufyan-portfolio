@extends('layouts.admin')

@section('title', 'Overview')

@section('content')
<div class="admin-heading">
    <div><span class="admin-eyebrow">YOUR LITTLE CORNER OF THE INTERNET</span><h1>Hey, {{ auth()->user()->name }}.</h1><p>Here’s what’s happening with your portfolio.</p></div>
    <a class="admin-button admin-button-link" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">VIEW SITE <span>↗</span></a>
</div>
<section class="admin-stats" aria-label="Portfolio summary">
    <article><span>ALL PROJECTS</span><strong>{{ $projectCount }}</strong><small>{{ $publishedProjectCount }} visible on your site</small></article>
    <article><span>MESSAGES</span><strong>{{ $messageCount }}</strong><small>Ideas and hellos from visitors</small></article>
</section>
<section class="admin-panel">
    <div class="admin-panel-heading"><div><span class="admin-eyebrow">THE LATEST HELLOS</span><h2>Recent messages</h2></div><a class="admin-text-link" href="{{ route('admin.messages.index') }}">ALL MESSAGES ↗</a></div>
    @forelse($latestMessages as $message)
        <a class="admin-message-row" href="{{ route('admin.messages.show', $message) }}">
            <span class="admin-message-avatar">{{ mb_strtoupper(mb_substr($message->name, 0, 1)) }}</span>
            <span class="admin-message-copy"><strong>{{ $message->name }}</strong><small>{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 70) }}</small></span>
            <time datetime="{{ $message->created_at->toAtomString() }}">{{ $message->created_at->diffForHumans() }}</time>
            <b>↗</b>
        </a>
    @empty
        <p class="admin-empty">No messages yet. When someone drops you a note, it’ll show up here.</p>
    @endforelse
</section>
<section class="admin-panel admin-project-shortcut">
    <div><span class="admin-eyebrow">KEEP THINGS FRESH</span><h2>Your projects, your way.</h2><p>Add a new project, update a preview, or tuck away something that’s no longer current.</p></div>
    <a class="admin-button admin-button-link" href="{{ route('admin.projects.index') }}">MANAGE PROJECTS <span>↗</span></a>
</section>
@endsection
