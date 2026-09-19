@extends('portfolio.layout')

@section('content')

<section class="max-w-2xl mx-auto px-4 sm:px-6 py-12 sm:py-20">
    <p class="text-xs sm:text-sm uppercase tracking-widest text-indigo-500 dark:text-indigo-400 mb-2">Contact</p>
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight">Get in touch</h1>
    <p class="mt-3 text-soft text-sm sm:text-base">
        Punya proyek, pertanyaan, atau hanya ingin menyapa? Kirim pesan di bawah — akan langsung masuk ke database.
    </p>

    {{-- Quick contact info --}}
    <div class="mt-6 grid sm:grid-cols-2 gap-3 text-sm">
        @if($profile->email ?? null)
            <a href="mailto:{{ $profile->email }}" class="surface rounded-lg p-4 hover-soft">
                <div class="text-mute text-xs">Email</div>
                <div class="font-medium break-words">{{ $profile->email }}</div>
            </a>
        @endif
        @if($profile->phone ?? null)
            <a href="tel:{{ $profile->phone }}" class="surface rounded-lg p-4 hover-soft">
                <div class="text-mute text-xs">Phone</div>
                <div class="font-medium">{{ $profile->phone }}</div>
            </a>
        @endif
    </div>

    {{-- Form --}}
    <div class="mt-8 surface rounded-xl p-5 sm:p-6">
        @if(session('status'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-500/10 border border-emerald-400/30 text-emerald-600 dark:text-emerald-300 text-xs sm:text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/10 border border-rose-400/30 text-rose-600 dark:text-rose-300 text-xs sm:text-sm">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-mute" for="name">Name</label>
                    <input id="name" name="name" type="text" required maxlength="120" value="{{ old('name') }}"
                           class="mt-1 w-full rounded-lg surface-2 border border-soft px-3 py-2 text-sm focus:outline-none focus:border-indigo-400">
                </div>
                <div>
                    <label class="text-xs text-mute" for="email">Email</label>
                    <input id="email" name="email" type="email" required maxlength="180" value="{{ old('email') }}"
                           class="mt-1 w-full rounded-lg surface-2 border border-soft px-3 py-2 text-sm focus:outline-none focus:border-indigo-400">
                </div>
            </div>
            <div>
                <label class="text-xs text-mute" for="subject">Subject <span class="opacity-50">(optional)</span></label>
                <input id="subject" name="subject" type="text" maxlength="180" value="{{ old('subject') }}"
                       class="mt-1 w-full rounded-lg surface-2 border border-soft px-3 py-2 text-sm focus:outline-none focus:border-indigo-400">
            </div>
            <div>
                <label class="text-xs text-mute" for="body">Message</label>
                <textarea id="body" name="body" rows="5" required maxlength="5000"
                          class="mt-1 w-full rounded-lg surface-2 border border-soft px-3 py-2 text-sm focus:outline-none focus:border-indigo-400">{{ old('body') }}</textarea>
            </div>
            <button type="submit" class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-indigo-500 hover:bg-indigo-400 text-white text-sm font-medium">
                Send message
            </button>
        </form>
    </div>
</section>

@endsection
