<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Student Portal') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#3c3c3c] text-slate-100">
    @php($isAuthenticated = session()->has('auth_user_id'))

    <div class="min-h-screen flex flex-col">
        <header class="border-b border-white/10 bg-[#3c3c3c]">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-white">
                    Student Portal
                </a>

                <nav class="flex items-center gap-3 text-sm text-slate-300">
                    @if ($isAuthenticated)
                        <a href="{{ route('dashboard') }}" class="rounded-full border border-white/20 px-4 py-2 text-slate-100 transition hover:border-white/30 hover:text-white">
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="rounded-full bg-slate-200 px-4 py-2 font-medium text-slate-900 transition hover:bg-white">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/20 px-4 py-2 transition hover:border-white/30 hover:text-white">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="rounded-full bg-slate-200 px-4 py-2 font-medium text-slate-950 transition hover:bg-white">
                            Register
                        </a>
                    @endif
                </nav>
            </div>
        </header>

        <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-8">
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

        <footer class="border-t border-white/10 bg-[#3c3c3c]">
            <div class="mx-auto max-w-7xl px-6 py-4 text-center text-xs text-slate-200/80">
                © {{ now()->year }} Angelo De Leon. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>
