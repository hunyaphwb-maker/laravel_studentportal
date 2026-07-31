@extends('layouts.app', ['title' => 'Forgot Password'])

@section('content')
    <section class="mx-auto max-w-md py-10">
        <div class="card">
            <div class="mb-8 space-y-2 text-center">
                <h1 class="text-3xl font-semibold text-white">Forgot your password?</h1>
                <p class="text-sm text-slate-300">Enter your email and we will send you a password reset link.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
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

                <button type="submit" class="form-button-primary w-full">
                    Send Reset Link
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-300">
                Remembered your password?
                <a href="{{ route('login') }}" class="font-semibold text-slate-100 hover:text-white">Back to login</a>
            </p>
        </div>
    </section>
@endsection

