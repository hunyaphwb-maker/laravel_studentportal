@extends('layouts.app', ['title' => 'Reset Password'])

@section('content')
    <section class="mx-auto max-w-md py-10">
        <div class="card">
            <div class="mb-8 space-y-2 text-center">
                <h1 class="text-3xl font-semibold text-white">Reset password</h1>
                <p class="text-sm text-slate-300">Set a new password for your account.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5" data-password-match-form>
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-slate-200">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $email) }}"
                        required
                        maxlength="255"
                        autocomplete="email"
                        class="form-input"
                    >
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-slate-200">New Password</label>
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
                    <label for="password_confirmation" class="text-sm font-medium text-slate-200">Confirm New Password</label>
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

                <p class="hidden rounded-2xl border border-rose-400/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200" data-password-match-message>
                    Passwords must match.
                </p>

                <button type="submit" class="form-button-primary w-full">
                    Update Password
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-300">
                <a href="{{ route('login') }}" class="font-semibold text-slate-100 hover:text-white">Back to login</a>
            </p>
        </div>
    </section>
@endsection

