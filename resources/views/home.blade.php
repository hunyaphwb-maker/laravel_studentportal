@extends('layouts.app', ['title' => 'Student Portal'])

@section('content')
    <section class="grid gap-10 py-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
        <div class="space-y-6">
            <span class="inline-flex rounded-full border border-cyan-400/30 bg-cyan-400/10 px-3 py-1 text-sm font-medium text-cyan-200">
                Secure Laravel + PDO Demo
            </span>

            <div class="space-y-4">
                <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-white md:text-5xl">
                    Login, registration, and dashboard CRUD in one polished student portal.
                </h1>
                <p class="max-w-2xl text-lg leading-8 text-slate-300">
                    This project uses Laravel 12, custom session-based authentication, PDO prepared statements, CSRF protection, and a protected dashboard for managing profile records.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                @if (session()->has('auth_user_id'))
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">
                        Open Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="rounded-full bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">
                        Create Account
                    </a>
                    <a href="{{ route('login') }}" class="rounded-full border border-white/15 px-5 py-3 font-semibold text-white transition hover:border-cyan-300 hover:text-cyan-200">
                        Log In
                    </a>
                @endif
            </div>
        </div>

        <div class="grid gap-4">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur">
                <h2 class="text-lg font-semibold text-white">What’s included</h2>
                <div class="mt-4 grid gap-4 text-sm text-slate-300">
                    <div class="rounded-2xl border border-white/8 bg-slate-900/60 p-4">
                        Session login with timeout handling and logout flow.
                    </div>
                    <div class="rounded-2xl border border-white/8 bg-slate-900/60 p-4">
                        Secure PDO queries using prepared statements for user and profile records.
                    </div>
                    <div class="rounded-2xl border border-white/8 bg-slate-900/60 p-4">
                        Protected CRUD dashboard with create, edit, read, and delete actions.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
