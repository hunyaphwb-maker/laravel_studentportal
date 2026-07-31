<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Student Portal') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    @php($isAuthenticated = session()->has('auth_user_id'))

    <div class="relative isolate min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.15),_transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(99,102,241,0.18),_transparent_30%),linear-gradient(180deg,_#020617_0%,_#0f172a_100%)]"></div>

        <header class="border-b border-white/10 bg-slate-950/70 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-white">
                    Student Portal
                </a>

                <nav class="flex items-center gap-3 text-sm text-slate-300">
                    @if ($isAuthenticated)
                        <a href="{{ route('dashboard') }}" class="rounded-full border border-cyan-400/40 px-4 py-2 text-cyan-200 transition hover:border-cyan-300 hover:text-white">
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="rounded-full bg-white px-4 py-2 font-medium text-slate-900 transition hover:bg-cyan-100">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/15 px-4 py-2 transition hover:border-cyan-300 hover:text-white">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="rounded-full bg-cyan-400 px-4 py-2 font-medium text-slate-950 transition hover:bg-cyan-300">
                            Register
                        </a>
                    @endif
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-rose-400/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-amber-400/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-100">
                    <p class="font-semibold">Please review the highlighted fields.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>
</html>
