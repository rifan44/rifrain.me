<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::query()->with('skill:id,name')->orderBy('sort_order')->orderBy('title')->get());
    }

    public function store(Request $request): RedirectResponse
    {
        Project::create($this->validated($request));
        return back()->with('status', 'Project created.');
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validated($request, $project));
        return back()->with('status', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return back()->with('status', 'Project deleted.');
    }

    private function validated(Request $request, ?Project $project = null): array
    {
        return $request->validate([
            'skill_id' => ['nullable', 'exists:skills,id'],
            'title' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140', Rule::unique('projects', 'slug')->ignore($project)],
            'summary' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'url' => ['nullable', 'url', 'max:2048'],
            'repository_url' => ['nullable', 'url', 'max:2048'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['sometimes', 'boolean'],
        ]);
    }
}
