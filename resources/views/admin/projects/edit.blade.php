@extends('layouts.admin')

@section('title', 'Edit '.$project->title)

@section('content')
<div class="admin-heading"><div><span class="admin-eyebrow">MAKE IT JUST RIGHT</span><h1>Edit project</h1><p>Update {{ $project->title }} whenever you need to.</p></div><a class="admin-text-link" href="{{ route('admin.projects.index') }}">← ALL PROJECTS</a></div>
<section class="admin-panel admin-editor">
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="admin-form">
        @csrf
        @method('PUT')
        @include('admin.projects._form')
    </form>
</section>
@endsection
