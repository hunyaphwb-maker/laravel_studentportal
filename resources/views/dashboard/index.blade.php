@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <section class="space-y-8">
        <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur">
                <span class="inline-flex rounded-full border border-cyan-400/30 bg-cyan-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-cyan-200">
                    Dashboard
                </span>

                <div class="mt-5 space-y-3">
                    <h1 class="text-3xl font-semibold text-white">Hello, {{ $user['name'] ?? session('auth_user_name') }}</h1>
                    <p class="text-slate-300">
                        Manage your profile records securely. Only logged-in users can access this page and all actions are protected by sessions and CSRF tokens.
                    </p>
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5">
                        <p class="text-sm text-slate-400">Signed-in Email</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $user['email'] ?? session('auth_user_email') }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5">
                        <p class="text-sm text-slate-400">Stored Profiles</p>
                        <p class="mt-2 text-3xl font-semibold text-cyan-200">{{ $profileCount }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-white">Create Profile Record</h2>
                    <p class="mt-2 text-sm text-slate-300">Use the form below to add a new record to your dashboard.</p>
                </div>

                <form action="{{ route('profiles.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @include('profiles.form', ['buttonLabel' => 'Save Profile'])
                </form>
            </div>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-2xl font-semibold text-white">Your Profile Records</h2>
                    <p class="mt-2 text-sm text-slate-300">Read, update, or delete records that you created from this account.</p>
                </div>
            </div>

            @if (count($profiles) === 0)
                <div class="mt-6 rounded-2xl border border-dashed border-white/15 bg-slate-900/60 px-6 py-10 text-center text-slate-300">
                    No profile records yet. Create your first one using the form above.
                </div>
            @else
                <div class="mt-6 overflow-hidden rounded-2xl border border-white/10">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/10 text-left text-sm">
                            <thead class="bg-slate-900/80 text-slate-300">
                                <tr>
                                    <th class="px-5 py-4 font-medium">Name</th>
                                    <th class="px-5 py-4 font-medium">Phone</th>
                                    <th class="px-5 py-4 font-medium">Address</th>
                                    <th class="px-5 py-4 font-medium">Birthdate</th>
                                    <th class="px-5 py-4 font-medium">Created</th>
                                    <th class="px-5 py-4 font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10 bg-slate-950/50 text-slate-200">
                                @foreach ($profiles as $profile)
                                    <tr>
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-white">{{ $profile['full_name'] }}</p>
                                            @if (! empty($profile['bio']))
                                                <p class="mt-1 max-w-xs text-xs text-slate-400">{!! nl2br(e(\Illuminate\Support\Str::limit($profile['bio'], 80))) !!}</p>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">{{ $profile['phone'] ?: 'N/A' }}</td>
                                        <td class="px-5 py-4">{{ $profile['address'] ?: 'N/A' }}</td>
                                        <td class="px-5 py-4">{{ $profile['birthdate'] ?: 'N/A' }}</td>
                                        <td class="px-5 py-4">{{ \Illuminate\Support\Carbon::parse($profile['created_at'])->format('M d, Y') }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex justify-end gap-3">
                                                <a href="{{ route('profiles.edit', $profile['id']) }}" class="form-button-secondary !px-4 !py-2 text-xs">
                                                    Edit
                                                </a>

                                                <form action="{{ route('profiles.destroy', $profile['id']) }}" method="POST" data-delete-confirm="Delete this record permanently?" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-full border border-rose-400/30 bg-rose-500/10 px-4 py-2 text-xs font-semibold text-rose-200 transition hover:border-rose-300 hover:bg-rose-500/20">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
