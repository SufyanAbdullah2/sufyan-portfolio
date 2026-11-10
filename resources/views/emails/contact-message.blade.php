<h1>You received a new portfolio message</h1>

<p><strong>From:</strong> {{ $contactMessage->name }}</p>
<p><strong>Email:</strong> {{ $contactMessage->email }}</p>
<p><strong>Subject:</strong> {{ $contactMessage->subject ?: 'No subject' }}</p>

<h2>Message</h2>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>
