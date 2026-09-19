<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <title>@yield('title', ($profile->name ?? 'Portfolio') . ' — ' . ($profile->title ?? ''))</title>
    <meta name="description" content="@yield('description', $profile->bio ?? 'Personal portfolio')">
    <meta name="author" content="{{ $profile->name ?? 'Portfolio' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', ($profile->name ?? 'Portfolio') . ' — ' . ($profile->title ?? ''))">
    <meta property="og:description" content="@yield('description', $profile->bio ?? 'Personal portfolio')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', ($profile->name ?? 'Portfolio') . ' — ' . ($profile->title ?? ''))">
    <meta name="twitter:description" content="@yield('description', $profile->bio ?? 'Personal portfolio')">
    @stack('head')

    {{-- Anti-flash theme bootstrap. Harus jalan SEBELUM Tailwind merender. --}}
    <script>
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = stored ?? (prefersDark ? 'dark' : 'light');
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                document.documentElement.dataset.theme = theme;
            } catch (e) { /* localStorage unavailable */ }
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfig Tailwind agar dark mode pakai class (default-nya sudah class, tapi eksplisit lebih jelas)
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        // Brand tetap; surface/ink dikontrol via CSS variables
                        brand: { 50:'#eef2ff', 100:'#e0e7ff', 200:'#c7d2fe', 300:'#a5b4fc', 400:'#818cf8', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 800:'#3730a3', 900:'#312e81' },
                    }
                }
            }
        };
    </script>

    <style>
        :root {
            --bg:           #f8fafc;       /* slate-50 */
            --bg-elev:     #ffffff;        /* white */
            --bg-elev-2:   #f1f5f9;        /* slate-100 */
            --text:        #0f172a;        /* slate-900 */
            --text-soft:   #475569;        /* slate-600 */
            --text-mute:   #64748b;        /* slate-500 */
            --border:      #e2e8f0;        /* slate-200 */
            --border-soft: #eef2f7;
            --hover:       rgba(15,23,42,0.05);
            --shadow:      0 1px 2px rgba(15,23,42,.04), 0 8px 24px rgba(15,23,42,.06);
            --gradient:    linear-gradient(90deg,#6366f1,#ec4899);
        }
        html.dark {
            --bg:         #020617;         /* slate-950 */
            --bg-elev:   #0f172a;          /* slate-900 */
            --bg-elev-2: #1e293b;          /* slate-800 */
            --text:      #f1f5f9;          /* slate-100 */
            --text-soft: #cbd5e1;          /* slate-300 */
            --text-mute: #94a3b8;          /* slate-400 */
            --border:    rgba(255,255,255,0.10);
            --border-soft: rgba(255,255,255,0.05);
            --hover:     rgba(255,255,255,0.05);
            --shadow:    0 1px 2px rgba(0,0,0,.3), 0 8px 24px rgba(0,0,0,.35);
        }
        html { -webkit-text-size-adjust: 100%; }
        body { font-size: 16px; overflow-x: hidden; background: var(--bg); color: var(--text); transition: background-color .2s ease, color .2s ease; }
        .gradient-text {
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .surface { background: var(--bg-elev); border: 1px solid var(--border); }
        .surface-2 { background: var(--bg-elev-2); }
        .text-soft { color: var(--text-soft); }
        .text-mute { color: var(--text-mute); }
        .border-soft { border-color: var(--border-soft); }
        .border-default { border-color: var(--border); }
        .hover-soft:hover { background: var(--hover); }
        #mobile-menu { transition: max-height .3s ease-in-out, opacity .2s ease-in-out; max-height: 0; opacity: 0; overflow: hidden; }
        #mobile-menu.open { max-height: 500px; opacity: 1; }
        .clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        /* Tombol toggle: rotasi halus */
        #theme-toggle .icon-sun, #theme-toggle .icon-moon { transition: transform .3s ease, opacity .2s ease; }
        html.dark #theme-toggle .icon-sun  { transform: rotate(90deg) scale(0); opacity: 0; position: absolute; }
        html.dark #theme-toggle .icon-moon { transform: rotate(0)     scale(1); opacity: 1; }
        html:not(.dark) #theme-toggle .icon-sun  { transform: rotate(0) scale(1); opacity: 1; }
        html:not(.dark) #theme-toggle .icon-moon { transform: rotate(-90deg) scale(0); opacity: 0; position: absolute; }
    </style>
</head>
<body class="antialiased">

<header class="sticky top-0 z-40 backdrop-blur" style="background: color-mix(in srgb, var(--bg) 80%, transparent); border-bottom: 1px solid var(--border-soft);">
    <!-- 3D Header Accent -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="fixed inset-0 transform-gpu perspective-1000" style="transform-style: preserve-3d;">
            <!-- 3D-inspired background planes -->
            <div class="absolute -top-6 -right-6 w-64 h-64 bg-indigo-600/10 rounded-2xl blur-lg opacity-60 -rotate-y-6 transform translate-x-20 translate-y-20"></div>
            <div class="absolute -bottom-6 -left-6 w-72 h-72 bg-purple-600/10 rounded-2xl blur-lg opacity-50 -rotate-y-4 transform translate-x-32 translate-y-32"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-blue-600/10 rounded-full blur-lg opacity-40 -rotate-x-2 transform translate-z-[-200px]"></div>
            <!-- Belem/lighting accent: 3D lamp post -->
            <div class="absolute -bottom-6 -right-8 w-24 h-40 bg-amber-500/20 rounded-3xl blur-lg opacity-50 transform rotate-x-3 translate-y-10 scale-75"></div>
            <div class="absolute -bottom-8 -right-6 w-8 h-80 bg-amber-500/30 rounded-full transform rotate-y-6 translate-y-4 scale-50"></div>
        </div>
    </div>
    
    <nav class="max-w-6xl mx-auto flex items-center justify-between px-4 sm:px-6 py-3 sm:py-4">

        <a href="{{ route('home') }}" class="font-semibold tracking-tight text-base sm:text-lg">
            <span class="gradient-text">{{ $profile->name ?? 'Your Name' }}</span>
        </a>

        <div class="hidden md:flex items-center gap-6 text-sm" style="color: var(--text-soft);">
            <a href="{{ route('home') }}#about"      class="hover:opacity-80 transition" style="color: inherit;">About</a>
            <a href="{{ route('home') }}#skills"     class="hover:opacity-80 transition" style="color: inherit;">Skills</a>
            <a href="{{ route('home') }}#projects"   class="hover:opacity-80 transition" style="color: inherit;">Projects</a>
            <a href="{{ route('home') }}#experience" class="hover:opacity-80 transition" style="color: inherit;">Experience</a>
            <a href="{{ route('about') }}"            class="hover:opacity-80 transition" style="color: inherit;">Resume</a>
            <a href="{{ route('contact') }}"          class="hover:opacity-80 transition" style="color: inherit;">Contact</a>
        </div>

        <div class="flex items-center gap-2">
            {{-- Theme toggle --}}
            <button id="theme-toggle" type="button" aria-label="Toggle color theme" title="Toggle dark/light"
                    class="relative w-10 h-10 inline-flex items-center justify-center rounded-lg border"
                    style="border-color: var(--border);">
                <svg class="icon-sun w-5 h-5"  fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="4"/>
                    <path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                </svg>
                <svg class="icon-moon w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            </button>

            {{-- Mobile burger --}}
            <button id="burger" type="button"
                    class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border"
                    style="border-color: var(--border);"
                    aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
                <svg id="icon-open"  class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18L18 6"/>
                </svg>
            </button>
        </div>
    </nav>

    <div id="mobile-menu" class="md:hidden" style="border-top: 1px solid var(--border-soft); background: var(--bg-elev);">
        <div class="px-4 py-3 flex flex-col gap-1 text-sm" style="color: var(--text-soft);">
            <a href="{{ route('home') }}#about"      class="px-3 py-2 rounded hover-soft" style="color: inherit;">About</a>
            <a href="{{ route('home') }}#skills"     class="px-3 py-2 rounded hover-soft" style="color: inherit;">Skills</a>
            <a href="{{ route('home') }}#projects"   class="px-3 py-2 rounded hover-soft" style="color: inherit;">Projects</a>
            <a href="{{ route('home') }}#experience" class="px-3 py-2 rounded hover-soft" style="color: inherit;">Experience</a>
            <a href="{{ route('about') }}"            class="px-3 py-2 rounded hover-soft" style="color: inherit;">Resume</a>
            <a href="{{ route('contact') }}"          class="px-3 py-2 rounded hover-soft" style="color: inherit;">Contact</a>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

@hasSection('jsonld')
    <script type="application/ld+json">@yield('jsonld')</script>
@endif

<footer class="mt-20 sm:mt-24" style="border-top: 1px solid var(--border-soft);">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8 text-sm text-mute flex flex-col sm:flex-row justify-between gap-3">
        <div>© {{ date('Y') }} {{ $profile->name ?? 'Your Name' }}. All rights reserved.</div>
        <div class="flex gap-4">
            @php $socials = $profile->socials ?? []; @endphp
            @if(!empty($socials['github']))   <a href="{{ $socials['github'] }}"   class="hover:opacity-80">GitHub</a>   @endif
            @if(!empty($socials['linkedin'])) <a href="{{ $socials['linkedin'] }}" class="hover:opacity-80">LinkedIn</a> @endif
            @if(!empty($socials['twitter']))  <a href="{{ $socials['twitter'] }}"  class="hover:opacity-80">Twitter</a>  @endif
        </div>
    </div>
</footer>

<script>
    // ===== Theme toggle =====
    (function () {
        const btn = document.getElementById('theme-toggle');
        if (!btn) return;
        btn.addEventListener('click', function () {
            const isDark = document.documentElement.classList.toggle('dark');
            const next = isDark ? 'dark' : 'light';
            try { localStorage.setItem('theme', next); } catch (e) {}
            document.documentElement.dataset.theme = next;
            // Update theme-color meta untuk address bar HP
            const meta = document.querySelector('meta[name="theme-color"]:not([media])') || document.querySelector('meta[name="theme-color"]');
            // biarkan; meta dengan media sudah handle
        });
        // Sinkronkan jika user ganti prefers-color-scheme (dan belum ada preferensi eksplisit)
        if (!localStorage.getItem('theme') && window.matchMedia) {
            const mq = window.matchMedia('(prefers-color-scheme: dark)');
            const handler = (e) => {
                if (localStorage.getItem('theme')) return; // user sudah pilih, jangan override
                if (e.matches) document.documentElement.classList.add('dark');
                else document.documentElement.classList.remove('dark');
                document.documentElement.dataset.theme = e.matches ? 'dark' : 'light';
            };
            mq.addEventListener ? mq.addEventListener('change', handler) : mq.addListener(handler);
        }
    })();

    // ===== Mobile menu =====
    (function () {
        const btn   = document.getElementById('burger');
        const menu  = document.getElementById('mobile-menu');
        const open  = document.getElementById('icon-open');
        const close = document.getElementById('icon-close');
        if (!btn || !menu) return;
        function toggle() {
            const isOpen = menu.classList.toggle('open');
            btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            open.classList.toggle('hidden', isOpen);
            close.classList.toggle('hidden', !isOpen);
        }
        btn.addEventListener('click', toggle);
        menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
            if (menu.classList.contains('open')) toggle();
        }));
    })();
</script>
</body>
</html>
