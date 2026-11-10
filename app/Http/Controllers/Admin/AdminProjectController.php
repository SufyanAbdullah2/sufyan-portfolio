<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::query()->orderBy('sort_order')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create', ['project' => new Project]);
    }

    public function store(Request $request): RedirectResponse
    {
        $project = Project::create($this->validatedProject($request));

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project created.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validatedProject($request));

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedProject(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:5000'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'project_url' => ['nullable', 'url:http,https', 'max:2048'],
            'year' => ['nullable', 'digits:4'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_published' => ['sometimes', 'boolean'],
        ]);

        $validated['is_published'] = (bool) ($validated['is_published'] ?? false);

        return $validated;
    }
}
