@extends('layouts.app', ['title' => 'Register'])

@section('content')
    <section class="mx-auto max-w-xl py-10">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur">
            <div class="mb-8 space-y-2 text-center">
                <h1 class="text-3xl font-semibold text-white">Create your account</h1>
                <p class="text-sm text-slate-300">Register securely, then start managing profile records from your dashboard.</p>
            </div>

            <form action="{{ route('register.store') }}" method="POST" class="space-y-5" data-password-match-form>
                @csrf

                <div class="space-y-2">
                    <label for="name" class="text-sm font-medium text-slate-200">Full Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        minlength="2"
                        maxlength="120"
                        autocomplete="name"
                        class="form-input"
                    >
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-slate-200">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        maxlength="255"
                        autocomplete="email"
                        class="form-input"
                    >
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium text-slate-200">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            class="form-input"
                        >
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-medium text-slate-200">Confirm Password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            data-confirm-password-target
                            class="form-input"
                        >
                    </div>
                </div>

                <p class="hidden rounded-2xl border border-rose-400/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200" data-password-match-message>
                    Passwords must match.
                </p>

                <button type="submit" class="form-button-primary w-full">
                    Register Account
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-300">
                Already registered?
                <a href="{{ route('login') }}" class="font-semibold text-cyan-200 hover:text-cyan-100">Go to login</a>
            </p>
        </div>
    </section>
@endsection
