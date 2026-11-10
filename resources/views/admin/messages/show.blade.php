@extends('layouts.admin')

@section('title', 'Message from '.$message->name)

@section('content')
<div class="admin-heading"><div><span class="admin-eyebrow">A NOTE FROM SOMEONE OUT THERE</span><h1>{{ $message->name }}</h1><p>Received {{ $message->created_at->format('F j, Y \a\t g:i a') }}</p></div><a class="admin-text-link" href="{{ route('admin.messages.index') }}">← ALL MESSAGES</a></div>
<article class="admin-panel admin-message-detail">
    <div class="admin-message-meta"><span>FROM</span><a href="mailto:{{ $message->email }}">{{ $message->email }} ↗</a></div>
    <div class="admin-message-meta"><span>SUBJECT</span><strong>{{ $message->subject ?: 'No subject' }}</strong></div>
    <div class="admin-message-body">{{ $message->message }}</div>
    <div class="admin-form-actions"><form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')<button class="admin-danger-link" type="submit">DELETE MESSAGE</button></form><a class="admin-button admin-button-link" href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->subject ?: 'Your portfolio message')) }}">REPLY BY EMAIL <span>↗</span></a></div>
</article>
@endsection
