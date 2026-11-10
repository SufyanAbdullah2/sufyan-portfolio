<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::query()
            ->whereIn('title', ['NORTHSTAR', 'FORM / FUNCTION', 'MONOCHROME'])
            ->update(['is_published' => false]);

        $projects = [
            [
                'title' => 'LAGUNITAS IPA',
                'category' => 'INTERACTIVE BRAND EXPERIENCE',
                'description' => 'An independent Lagunitas IPA concept with a motion-led can reveal, tasting specs, brewery video and a playful brew finder.',
                'image_url' => '/images/projects/lagunitas-can.png',
                'project_url' => null, 'year' => '2026', 'sort_order' => 1,
            ],
            [
                'title' => 'STUDIOVA',
                'category' => 'LARAVEL / DIGITAL STUDIO',
                'description' => 'A full-stack agency platform with a polished marketing site, authenticated admin dashboard, contact inbox and inquiry management.',
                'image_url' => '/images/projects/studiova-services-img-1.jpg',
                'project_url' => null, 'year' => '2026', 'sort_order' => 2,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['title' => $project['title']], $project + ['is_published' => true]);
        }
    }
}
