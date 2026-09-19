@extends('portfolio.layout')

@section('content')

<section class="max-w-6xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
    <a href="{{ route('home') }}#projects" class="text-sm text-mute hover:opacity-80 inline-flex items-center gap-1">
        <span aria-hidden="true">←</span> Back to home
    </a>

    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight mt-3">All Projects</h1>
    <p class="mt-2 text-soft text-sm sm:text-base">{{ $projects->total() }} proyek di portfolio.</p>

    {{-- Filter bar (client-side, no-JS fallback aman) --}}
    @if(!empty($allTech))
    <div class="mt-6 flex flex-wrap gap-2">
        <button type="button" data-filter="all"
                class="filter-btn px-3 py-1.5 rounded-full text-xs border border-default hover-soft">
            All
        </button>
        @foreach($allTech as $tech)
            <button type="button" data-filter="{{ $tech }}"
                    class="filter-btn px-3 py-1.5 rounded-full text-xs border border-default hover-soft">
                {{ $tech }}
            </button>
        @endforeach
    </div>
    @endif

    @if($projects->isEmpty())
        <div class="mt-8 surface rounded-xl border border-dashed border-default p-10 text-center text-mute text-sm">
            No projects yet.
        </div>
    @else
        <div id="projects-grid" class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}"
                   data-tech="@if(!empty($project->tech_stack)){{ implode('|', $project->tech_stack) }}@endif"
                   class="project-card group block surface rounded-xl overflow-hidden hover:border-indigo-400/60 transition">
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
                                    <span class="text-[10px] px-2 py-0.5 rounded surface-2 border border-soft text-soft">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $projects->links() }}
        </div>
    @endif
</section>

<script>
    // Client-side filter (graceful: tombol tetap terlihat walaupun JS off)
    (function () {
        const buttons = document.querySelectorAll('.filter-btn');
        const cards   = document.querySelectorAll('.project-card');
        if (!buttons.length || !cards.length) return;

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const f = btn.dataset.filter;
                buttons.forEach(b => b.style.opacity = b === btn ? '1' : '0.6');
                cards.forEach(c => {
                    if (f === 'all') { c.style.display = ''; return; }
                    const techs = (c.dataset.tech || '').split('|');
                    c.style.display = techs.includes(f) ? '' : 'none';
                });
            });
        });
    })();
</script>

@endsection
