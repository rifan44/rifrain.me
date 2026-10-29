<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Project;
use App\Models\SiteContent;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $laravel = Skill::create(['name' => 'Laravel', 'category' => 'Backend', 'icon' => 'php', 'sort_order' => 1]);
        $js = Skill::create(['name' => 'JavaScript', 'category' => 'Frontend', 'icon' => 'js', 'sort_order' => 2]);
        Skill::create(['name' => 'UI/UX', 'category' => 'Design', 'icon' => 'palette', 'sort_order' => 3]);

        Project::create([
            'skill_id' => $laravel->id,
            'title' => 'Interactive Portfolio',
            'slug' => 'interactive-portfolio',
            'summary' => 'A playable portfolio experience.',
            'description' => 'A Laravel CMS paired with a lightweight Kaboom.js platformer.',
            'sort_order' => 1,
        ]);
        Project::create([
            'skill_id' => $js->id,
            'title' => 'Realtime Dashboard',
            'slug' => 'realtime-dashboard',
            'summary' => 'A focused data visualization dashboard.',
            'description' => 'Responsive charts and live status updates for product teams.',
            'sort_order' => 2,
        ]);

        Experience::create([
            'company' => 'Freelance Studio',
            'role' => 'Full-stack Engineer',
            'location' => 'Remote',
            'started_at' => '2023-01-01',
            'description' => 'Building maintainable web products from database to interface.',
            'is_current' => true,
        ]);

        SiteContent::create(['key' => 'about', 'title' => 'About me', 'body' => 'I build reliable, expressive web experiences with a product mindset.']);
        SiteContent::create(['key' => 'contact', 'title' => 'Contact', 'body' => 'Ready to build something useful? Send a message and let us talk.']);
    }
}
