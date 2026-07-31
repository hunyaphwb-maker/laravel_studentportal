@extends('layouts.app', ['title' => 'Edit Profile'])

@section('content')
    <section class="mx-auto max-w-4xl space-y-6">
        <div class="card">
            <h1 class="text-3xl font-semibold text-white">Edit Profile Record</h1>
            <p class="mt-3 text-slate-300">
                Update the selected record below. The form uses server-side validation and PDO prepared statements on save.
            </p>
        </div>

        <div class="card">
            <form action="{{ route('profiles.update', $profile['id']) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                @include('profiles.form', [
                    'profile' => $profile,
                    'buttonLabel' => 'Update Profile',
                    'cancelRoute' => route('dashboard'),
                ])
            </form>
        </div>
    </section>
@endsection
