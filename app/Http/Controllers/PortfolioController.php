<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\SiteContent;
use App\Models\Skill;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $skills = Skill::query()->orderBy('sort_order')->orderBy('name')->get();
        $projects = Project::query()->with('skill:id,name')->orderBy('sort_order')->orderBy('title')->get();
        $experiences = Experience::query()->orderByDesc('is_current')->orderByDesc('started_at')->orderBy('sort_order')->get();
        $content = SiteContent::query()->whereIn('key', ['about', 'contact'])->get()->keyBy('key');

        return view('portfolio', compact('skills', 'projects', 'experiences', 'content'));
    }
}
