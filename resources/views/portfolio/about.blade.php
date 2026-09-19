@extends('portfolio.layout')

@section('content')

<section class="max-w-3xl mx-auto px-4 sm:px-6 py-12 sm:py-20">
    <p class="text-xs sm:text-sm uppercase tracking-widest text-indigo-500 dark:text-indigo-400 mb-2">Resume</p>
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight">About {{ $profile->name ?? 'Me' }}</h1>
    <p class="mt-3 text-base sm:text-lg text-soft">{{ $profile->title ?? '' }}</p>
    <p class="mt-1 text-sm text-mute">{{ $profile->location ?? '' }} · {{ $profile->email ?? '' }}</p>

    <article class="prose max-w-none mt-8 sm:mt-10 text-soft leading-relaxed whitespace-pre-line">
        {!! $profile->bio_long ?? ($profile->bio ?? 'No biography provided yet.') !!}
    </article>

    @if(!empty($profile->cv_url))
        <div class="mt-8">
            <a href="{{ $profile->cv_url }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white text-sm font-medium">
                Download CV
            </a>
        </div>
    @endif
</section>

{{-- Education & Certifications (jika ada di profile->extras) --}}
@php $extras = $profile->extras ?? []; @endphp
@if(!empty($extras['education']) || !empty($extras['certifications']))
<section class="max-w-3xl mx-auto px-4 sm:px-6 py-8 grid sm:grid-cols-2 gap-6">
    @if(!empty($extras['education']))
        <div class="surface rounded-xl p-5">
            <h2 class="text-sm uppercase tracking-widest text-mute mb-3">Education</h2>
            <ul class="space-y-3 text-sm">
                @foreach($extras['education'] as $edu)
                    <li>
                        <div class="font-medium">{{ $edu['school'] ?? '' }}</div>
                        <div class="text-mute text-xs">{{ $edu['year'] ?? '' }}</div>
                        @if(!empty($edu['degree']))
                            <div class="text-soft text-xs mt-0.5">{{ $edu['degree'] }}</div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(!empty($extras['certifications']))
        <div class="surface rounded-xl p-5">
            <h2 class="text-sm uppercase tracking-widest text-mute mb-3">Certifications</h2>
            <ul class="space-y-2 text-sm">
                @foreach($extras['certifications'] as $cert)
                    <li>
                        <div class="font-medium">{{ $cert['name'] ?? '' }}</div>
                        <div class="text-mute text-xs">{{ $cert['issuer'] ?? '' }}{{ !empty($cert['year']) ? ' · '.$cert['year'] : '' }}</div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</section>
@endif

@endsection
