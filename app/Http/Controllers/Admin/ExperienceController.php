<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return response()->json(Experience::query()->orderByDesc('is_current')->orderByDesc('started_at')->get());
    }

    public function store(Request $request): RedirectResponse
    {
        Experience::create($this->validated($request));
        return back()->with('status', 'Experience created.');
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $experience->update($this->validated($request));
        return back()->with('status', 'Experience updated.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();
        return back()->with('status', 'Experience deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'company' => ['required', 'string', 'max:120'],
            'role' => ['required', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'description' => ['nullable', 'string', 'max:10000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_current' => ['sometimes', 'boolean'],
        ]);
    }
}
