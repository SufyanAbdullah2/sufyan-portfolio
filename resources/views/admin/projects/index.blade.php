@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<div class="admin-heading">
    <div><span class="admin-eyebrow">THE THINGS YOU’VE MADE</span><h1>Projects</h1><p>Keep your portfolio up to date, one little detail at a time.</p></div>
    <a class="admin-button admin-button-link" href="{{ route('admin.projects.create') }}">ADD A PROJECT <span>＋</span></a>
</div>
<section class="admin-panel admin-table-wrap">
    <table class="admin-table">
        <thead><tr><th>PROJECT</th><th>CATEGORY</th><th>YEAR</th><th>STATUS</th><th></th></tr></thead>
        <tbody>
        @forelse($projects as $project)
            <tr>
                <td><strong>{{ $project->title }}</strong><small>{{ \Illuminate\Support\Str::limit($project->description, 58) }}</small></td>
                <td>{{ $project->category }}</td>
                <td>{{ $project->year ?: '—' }}</td>
                <td><span class="admin-status {{ $project->is_published ? 'is-published' : 'is-draft' }}">{{ $project->is_published ? 'Published' : 'Draft' }}</span></td>
                <td class="admin-table-actions"><a href="{{ route('admin.projects.edit', $project) }}">Edit ↗</a><form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Delete this project?')">@csrf @method('DELETE')<button type="submit">Delete</button></form></td>
            </tr>
        @empty
            <tr><td colspan="5" class="admin-empty">No projects yet. Add the first one when you’re ready.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $projects->links() }}
</section>
@endsection
