@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<div class="admin-heading"><div><span class="admin-eyebrow">NOTES FROM PEOPLE OUT THERE</span><h1>Your messages</h1><p>Every message is a chance to start something good.</p></div></div>
<section class="admin-panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>FROM</th><th>SUBJECT / NOTE</th><th>RECEIVED</th><th></th></tr></thead>
        <tbody>
        @forelse($messages as $message)
            <tr>
                <td><strong>{{ $message->name }}</strong><small>{{ $message->email }}</small></td>
                <td>{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 72) }}</td>
                <td><time datetime="{{ $message->created_at->toAtomString() }}">{{ $message->created_at->format('M j, Y · g:i a') }}</time></td>
                <td class="admin-table-actions"><a href="{{ route('admin.messages.show', $message) }}">Read ↗</a></td>
            </tr>
        @empty
            <tr><td colspan="4" class="admin-empty">No messages yet. They’ll find their way here.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $messages->links() }}
</section>
@endsection
