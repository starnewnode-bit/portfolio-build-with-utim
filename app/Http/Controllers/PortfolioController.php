<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function home()
    {
        $profile     = Profile::first() ?? new Profile(['name' => 'Your Name']);
        $skills      = Skill::orderBy('category')->orderBy('name')->get();
        $projects    = Project::where('is_published', true)
                            ->orderByDesc('is_featured')
                            ->orderByDesc('published_at')
                            ->limit(6)
                            ->get();
        $experiences = Experience::orderByDesc('is_current')
                            ->orderByDesc('start_date')
                            ->get();

        // Home butuh Profile untuk footer (socials) — variabel $profile sudah ada
        return view('portfolio.home', compact('profile', 'skills', 'projects', 'experiences'));
    }

    public function about()
    {
        $profile = Profile::first() ?? new Profile(['name' => 'Your Name']);
        return view('portfolio.about', compact('profile'));
    }

    public function projectsIndex(Request $request)
    {
        $query = Project::where('is_published', true)
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at');

        // Optional: ?tech= filter
        if ($tech = $request->query('tech')) {
            // SQLite JSON contains — works for json columns stored as TEXT
            $query->where('tech_stack', 'like', '%"'.$tech.'"%');
        }

        $projects   = $query->paginate(12)->withQueryString();
        $allTech    = Project::where('is_published', true)
                            ->whereNotNull('tech_stack')
                            ->pluck('tech_stack')
                            ->filter()
                            ->flatten()
                            ->unique()
                            ->sort()
                            ->values()
                            ->all();

        return view('portfolio.projects.index', compact('projects', 'allTech'));
    }

    public function showProject(string $slug)
    {
        $project = Project::where('slug', $slug)
                        ->where('is_published', true)
                        ->firstOrFail();

        $related = Project::where('is_published', true)
                        ->where('id', '!=', $project->id)
                        ->orderByDesc('is_featured')
                        ->orderByDesc('published_at')
                        ->limit(3)
                        ->get();

        $profile = Profile::first() ?? new Profile(['name' => 'Your Name']);

        return view('portfolio.project', compact('project', 'related', 'profile'));
    }

    public function contact()
    {
        $profile = Profile::first() ?? new Profile(['name' => 'Your Name']);
        return view('portfolio.contact', compact('profile'));
    }

    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:180'],
            'subject' => ['nullable', 'string', 'max:180'],
            'body'    => ['required', 'string', 'max:5000'],
        ]);

        Message::create($data);

        return redirect()->route('contact')->with('status', 'Pesan terkirim. Terima kasih!');
    }
}
