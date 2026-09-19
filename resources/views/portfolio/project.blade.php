@extends('portfolio.layout')

@section('title', $project->title . ' — ' . ($profile->name ?? 'Portfolio'))
@section('description', $project->short_description ?? \Illuminate\Support\Str::limit(strip_tags($project->description ?? ''), 160, ''))
@section('og_type', 'article')

@section('jsonld')
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'CreativeWork',
    'name'     => $project->title,
    'description' => $project->short_description ?? \Illuminate\Support\Str::limit(strip_tags($project->description ?? ''), 160, ''),
    'url'      => route('projects.show', $project->slug),
    'author'   => [
        '@type' => 'Person',
        'name'  => $profile->name ?? 'Portfolio',
    ],
    'datePublished' => optional($project->published_at)->toIso8601String(),
    'keywords'    => is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : (string) $project->tech_stack,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
@endsection

@section('content')
@php
    $tech = is_array($project->tech_stack) ? $project->tech_stack : (json_decode($project->tech_stack ?? '[]', true) ?: []);
@endphp

<section class="max-w-4xl mx-auto px-4 sm:px-6 py-10 sm:py-14">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-mute mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:opacity-80">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('projects.index') }}" class="hover:opacity-80">Projects</a>
        <span class="mx-2">/</span>
        <span class="text-soft">{{ $project->title }}</span>
    </nav>

    {{-- Header --}}
    <header class="mb-8 sm:mb-10">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight mb-3">
            {{ $project->title }}
        </h1>
        @if($project->short_description)
            <p class="text-base sm:text-lg text-soft">{{ $project->short_description }}</p>
        @endif

        <div class="mt-5 flex flex-wrap items-center gap-3 text-sm text-mute">
            @if($project->published_at)
                <time datetime="{{ $project->published_at->toDateString() }}">
                    {{ $project->published_at->format('M Y') }}
                </time>
            @endif
            @if($project->is_featured)
                <span class="px-2 py-0.5 rounded-full text-xs font-medium" style="background: var(--gradient); color: white;">Featured</span>
            @endif
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            <a href="{{ route('projects.index') }}" class="px-3 py-1.5 rounded-lg border text-sm hover-soft" style="border-color: var(--border);">
                ← All projects
            </a>
            @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-lg text-sm text-white" style="background: var(--gradient);">
                    Live demo ↗
                </a>
            @endif
            @if($project->repo_url)
                <a href="{{ $project->repo_url }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-lg border text-sm hover-soft" style="border-color: var(--border);">
                    Source code ↗
                </a>
            @endif
        </div>
    </header>

    {{-- Cover image (opsional) --}}
    @if(!empty($project->cover_image))
        <div class="mb-8 sm:mb-10 overflow-hidden rounded-xl border" style="border-color: var(--border);">
            <img src="{{ $project->cover_image }}" alt="{{ $project->title }}" class="w-full h-auto" loading="lazy">
        </div>
    @endif

    {{-- Description --}}
    @if($project->description)
        <article class="prose max-w-none text-base sm:text-lg leading-relaxed" style="color: var(--text-soft);">
            {!! nl2br(e($project->description)) !!}
        </article>
    @endif

    {{-- Tech stack --}}
    @if(!empty($tech))
        <div class="mt-10">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-mute mb-3">Tech stack</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($tech as $t)
                    <span class="px-2.5 py-1 rounded-md text-xs font-medium surface">{{ $t }}</span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Related --}}
    @if($related->count())
        <section class="mt-14 sm:mt-16">
            <h2 class="text-xl sm:text-2xl font-semibold tracking-tight mb-5">Related projects</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($related as $r)
                    <a href="{{ route('projects.show', $r->slug) }}" class="block surface rounded-xl p-4 hover-soft transition">
                        <div class="text-sm font-semibold mb-1 clamp-2">{{ $r->title }}</div>
                        @if($r->short_description)
                            <p class="text-xs text-mute clamp-2">{{ $r->short_description }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

</section>
@endsection
