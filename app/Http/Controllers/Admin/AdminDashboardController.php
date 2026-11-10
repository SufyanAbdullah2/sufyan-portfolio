<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'publishedProjectCount' => Project::where('is_published', true)->count(),
            'messageCount' => ContactMessage::count(),
            'latestMessages' => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}
