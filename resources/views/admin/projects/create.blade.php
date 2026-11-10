@extends('layouts.admin')

@section('title', 'Add a project')

@section('content')
<div class="admin-heading"><div><span class="admin-eyebrow">A NEW THING YOU’VE MADE</span><h1>Add a project</h1><p>Share a little story about what you built.</p></div><a class="admin-text-link" href="{{ route('admin.projects.index') }}">← ALL PROJECTS</a></div>
<section class="admin-panel admin-editor">
    <form method="POST" action="{{ route('admin.projects.store') }}" class="admin-form">
        @csrf
        @include('admin.projects._form')
    </form>
</section>
@endsection
