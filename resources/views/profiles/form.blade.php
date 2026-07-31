@php
    $record = $profile ?? null;
    $fullName = old('full_name', $record['full_name'] ?? '');
    $phone = old('phone', $record['phone'] ?? '');
    $address = old('address', $record['address'] ?? '');
    $birthdate = old('birthdate', $record['birthdate'] ?? '');
    $bio = old('bio', $record['bio'] ?? '');
@endphp

<div class="grid gap-5 md:grid-cols-2">
    <div class="space-y-2 md:col-span-2">
        <label for="full_name" class="text-sm font-medium text-slate-200">Profile Name</label>
        <input
            id="full_name"
            name="full_name"
            type="text"
            value="{{ $fullName }}"
            required
            minlength="2"
            maxlength="120"
            class="form-input"
        >
    </div>

    <div class="space-y-2">
        <label for="phone" class="text-sm font-medium text-slate-200">Phone Number</label>
        <input
            id="phone"
            name="phone"
            type="text"
            value="{{ $phone }}"
            maxlength="25"
            pattern="[0-9+\-\s()]*"
            class="form-input"
        >
    </div>

    <div class="space-y-2">
        <label for="birthdate" class="text-sm font-medium text-slate-200">Birthdate</label>
        <input
            id="birthdate"
            name="birthdate"
            type="date"
            value="{{ $birthdate }}"
            max="{{ now()->toDateString() }}"
            class="form-input"
        >
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="address" class="text-sm font-medium text-slate-200">Address</label>
        <input
            id="address"
            name="address"
            type="text"
            value="{{ $address }}"
            maxlength="255"
            class="form-input"
        >
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="bio" class="text-sm font-medium text-slate-200">Short Bio</label>
        <textarea
            id="bio"
            name="bio"
            rows="4"
            maxlength="1000"
            class="form-input min-h-32"
        >{{ $bio }}</textarea>
    </div>
</div>

<div class="flex flex-wrap gap-3">
    <button type="submit" class="form-button-primary">
        {{ $buttonLabel }}
    </button>

    @isset($cancelRoute)
        <a href="{{ $cancelRoute }}" class="form-button-secondary">
            Cancel
        </a>
    @endisset
</div>
