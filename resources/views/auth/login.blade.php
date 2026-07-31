@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <section class="mx-auto max-w-md py-10">
        <div class="card">
            <div class="mb-8 space-y-2 text-center">
                <h1 class="text-3xl font-semibold text-white">Welcome back</h1>
                <p class="text-sm text-slate-300">Log in to access your protected dashboard and profile records.</p>
            </div>

            <form action="{{ route('login.attempt') }}" method="POST" class="space-y-5">
                @csrf

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

                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-slate-200">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        minlength="8"
                        autocomplete="current-password"
                        class="form-input"
                    >
                </div>

                <button type="submit" class="form-button-primary w-full">
                    Log In
                </button>
            </form>

            <div class="mt-5 text-center text-sm">
                <a href="{{ route('password.request') }}" class="font-semibold text-slate-100 hover:text-white">
                    Forgot password?
                </a>
            </div>

            <p class="mt-6 text-center text-sm text-slate-300">
                Need an account?
                <a href="{{ route('register') }}" class="font-semibold text-slate-100 hover:text-white">Register here</a>
            </p>
        </div>
    </section>
@endsection
