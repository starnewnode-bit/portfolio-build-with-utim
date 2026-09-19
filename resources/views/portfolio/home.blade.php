@extends('portfolio.layout')

@section('content')

{{-- HERO --}}
<section class="max-w-6xl mx-auto px-4 sm:px-6 pt-12 sm:pt-20 pb-16 sm:pb-24 text-center">
    <p class="text-xs sm:text-sm uppercase tracking-widest text-indigo-500 dark:text-indigo-400 mb-3 sm:mb-4">Welcome</p>
    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight leading-tight">
        Hi, I'm <span class="gradient-text">{{ $profile->name ?? 'Your Name' }}</span>
    </h1>
    <p class="mt-3 sm:mt-4 text-base sm:text-xl text-soft px-2">{{ $profile->title ?? 'Full-Stack Developer' }}</p>
    <p class="mt-2 text-sm sm:text-base text-mute break-words">
        {{ $profile->location ?? 'Indonesia' }} · {{ $profile->email ?? 'hello@example.com' }}
    </p>

    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row justify-center gap-3 px-4 sm:px-0">
        <a href="#projects" class="px-5 py-2.5 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white text-sm font-medium">
            View Projects
        </a>
        @if(!empty($profile->cv_url))
            <a href="{{ $profile->cv_url }}" class="px-5 py-2.5 rounded-lg border border-default hover-soft text-sm">
                Download CV
            </a>
        @endif
    </div>
</section>

{{-- ABOUT --}}
<section id="about" class="max-w-3xl mx-auto px-4 sm:px-6 py-12 sm:py-16 scroll-mt-20">
    <h2 class="text-xl sm:text-2xl font-semibold mb-3 sm:mb-4">About</h2>
    <p class="text-sm sm:text-base text-soft leading-relaxed">
        {{ $profile->bio ?? 'This is a placeholder bio. Replace it with a short introduction about who you are, what you build, and what you care about.' }}
    </p>

    @if($profile->phone ?? null)
        <p class="mt-3 text-xs sm:text-sm text-mute">📞 {{ $profile->phone }}</p>
    @endif

    <div class="mt-5">
        <a href="{{ route('about') }}" class="text-sm text-indigo-500 dark:text-indigo-400 hover:underline">
            More about me →
        </a>
    </div>
</section>

{{-- SKILLS --}}
<section id="skills" class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16 scroll-mt-20">
    <h2 class="text-xl sm:text-2xl font-semibold mb-6 sm:mb-8">Skills</h2>

    @if($skills->isEmpty())
        <p class="text-mute text-sm">No skills added yet.</p>
    @else
        @php $grouped = $skills->groupBy('category'); @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-8">
            @foreach($grouped as $category => $items)
                <div class="rounded-xl surface p-4 sm:p-5">
                    <h3 class="text-xs sm:text-sm uppercase tracking-widest text-mute mb-3">
                        {{ ucfirst($category) }}
                    </h3>
                    <ul class="space-y-3">
                        @foreach($items as $skill)
                            <li>
                                <div class="flex justify-between text-xs sm:text-sm mb-1">
                                    <span>{{ $skill->name }}</span>
                                    <span class="text-mute">{{ $skill->level }}%</span>
                                </div>
                                <div class="h-2 rounded surface-2 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-pink-500" style="width: {{ $skill->level }}%"></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
</section>

{{-- PROJECTS --}}
<section id="projects" class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16 scroll-mt-20">
    <div class="flex items-end justify-between mb-6 sm:mb-8">
        <h2 class="text-xl sm:text-2xl font-semibold">Projects</h2>
        <a href="{{ route('projects.index') }}" class="text-xs sm:text-sm text-indigo-500 dark:text-indigo-400 hover:underline">
            View all →
        </a>
    </div>

    @if($projects->isEmpty())
        <div class="rounded-xl border border-dashed border-default p-8 sm:p-10 text-center text-mute text-sm">
            No projects yet. Add via seeder to populate this section.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}"
                   class="group block rounded-xl surface overflow-hidden hover:border-indigo-400/60 transition">
                    <div class="aspect-video surface-2 flex items-center justify-center text-mute text-xs sm:text-sm">
                        {{ $project->cover_image ? 'Cover image' : 'No cover image' }}
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="font-semibold text-sm sm:text-base group-hover:text-indigo-500 dark:group-hover:text-indigo-300 leading-tight">
                                {{ $project->title }}
                            </h3>
                            @if($project->is_featured)
                                <span class="text-[10px] uppercase tracking-widest text-amber-500 dark:text-amber-300 whitespace-nowrap mt-1">
                                    Featured
                                </span>
                            @endif
                        </div>
                        <p class="text-xs sm:text-sm text-mute clamp-2">{{ $project->summary ?? '—' }}</p>
                        @if(!empty($project->tech_stack))
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach(array_slice($project->tech_stack, 0, 4) as $tech)
                                    <span class="text-[10px] px-2 py-0.5 rounded surface-2 border border-soft text-soft">
                                        {{ $tech }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</section>

{{-- EXPERIENCE --}}
<section id="experience" class="max-w-3xl mx-auto px-4 sm:px-6 py-12 sm:py-16 scroll-mt-20">
    <h2 class="text-xl sm:text-2xl font-semibold mb-6 sm:mb-8">Experience</h2>

    @if($experiences->isEmpty())
        <p class="text-mute text-sm">No experience entries yet.</p>
    @else
        <ol class="relative border-l border-default pl-5 sm:pl-6 space-y-6 sm:space-y-8">
            @foreach($experiences as $exp)
                <li>
                    <span class="absolute -left-1.5 mt-1.5 h-3 w-3 rounded-full bg-indigo-500 dark:bg-indigo-400"></span>
                    <div class="text-xs sm:text-sm text-mute">
                        {{ $exp->start_date->format('M Y') }}
                        — {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('M Y') ?? '—') }}
                    </div>
                    <h3 class="font-semibold mt-1 text-sm sm:text-base">
                        {{ $exp->role }}
                        <span class="text-mute">@ {{ $exp->company }}</span>
                    </h3>
                    @if($exp->location)
                        <p class="text-xs text-mute">{{ $exp->location }}</p>
                    @endif
                    @if($exp->description)
                        <p class="text-xs sm:text-sm text-soft mt-2 leading-relaxed">{{ $exp->description }}</p>
                    @endif
                    @if(!empty($exp->highlights))
                        <ul class="mt-2 space-y-1 text-xs sm:text-sm text-soft">
                            @foreach($exp->highlights as $h)
                                <li class="flex gap-2"><span class="text-indigo-500 dark:text-indigo-400">•</span><span>{{ $h }}</span></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ol>
    @endif
</section>

{{-- CONTACT (ringkas) --}}
<section id="contact" class="max-w-2xl mx-auto px-4 sm:px-6 py-12 sm:py-16 scroll-mt-20">
    <h2 class="text-xl sm:text-2xl font-semibold mb-2">Get in touch</h2>
    <p class="text-mute text-xs sm:text-sm mb-5 sm:mb-6">
        Ingin berkolaborasi atau punya pertanyaan? <a href="{{ route('contact') }}" class="text-indigo-500 dark:text-indigo-400 hover:underline">Kirim pesan</a> — langsung masuk ke database.
    </p>

    <div class="grid sm:grid-cols-2 gap-3 text-xs sm:text-sm">
        <a href="mailto:{{ $profile->email ?? '#' }}" class="surface rounded-lg p-3 hover-soft">
            <div class="text-mute">Email</div>
            <div class="font-medium break-words">{{ $profile->email ?? '—' }}</div>
        </a>
        @if($profile->phone ?? null)
            <a href="tel:{{ $profile->phone }}" class="surface rounded-lg p-3 hover-soft">
                <div class="text-mute">Phone</div>
                <div class="font-medium">{{ $profile->phone }}</div>
            </a>
        @endif
    </div>
</section>

@endsection
