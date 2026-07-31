<?php

namespace App\Http\Controllers;

use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileRepository $profiles,
        private readonly UserRepository $users,
    ) {
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProfile($request);
        $userId = (int) $request->session()->get('auth_user_id');

        try {
            $this->profiles->create($userId, $this->sanitizeProfilePayload($validated));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'We could not save the profile record right now.');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profile record created successfully.');
    }

    public function edit(Request $request, int $profile): View|RedirectResponse
    {
        $userId = (int) $request->session()->get('auth_user_id');
        $profileRecord = $this->profiles->findOwnedById($profile, $userId);

        if (! $profileRecord) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'The selected profile could not be found.');
        }

        return view('profiles.edit', [
            'user' => $this->users->findById($userId),
            'profile' => $profileRecord,
        ]);
    }

    public function update(Request $request, int $profile): RedirectResponse
    {
        $validated = $this->validateProfile($request);
        $userId = (int) $request->session()->get('auth_user_id');

        if (! $this->profiles->findOwnedById($profile, $userId)) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'The selected profile could not be found.');
        }

        try {
            $this->profiles->update($profile, $userId, $this->sanitizeProfilePayload($validated));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'We could not update the profile record right now.');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profile record updated successfully.');
    }

    public function destroy(Request $request, int $profile): RedirectResponse
    {
        $userId = (int) $request->session()->get('auth_user_id');

        if (! $this->profiles->findOwnedById($profile, $userId)) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'The selected profile could not be found.');
        }

        try {
            $this->profiles->delete($profile, $userId);
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('dashboard')
                ->with('error', 'We could not delete the profile record right now.');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profile record deleted successfully.');
    }

    private function validateProfile(Request $request): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'min:2', 'max:120'],
            'phone' => ['nullable', 'string', 'max:25', 'regex:/^[0-9+\-\s()]*$/'],
            'address' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date', 'before_or_equal:today'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function sanitizeProfilePayload(array $validated): array
    {
        return [
            'full_name' => $this->sanitizeText($validated['full_name']),
            'phone' => $this->nullableSanitizedText($validated['phone'] ?? null),
            'address' => $this->nullableSanitizedText($validated['address'] ?? null),
            'birthdate' => $validated['birthdate'] ?: null,
            'bio' => $this->nullableSanitizedText($validated['bio'] ?? null),
        ];
    }

    private function sanitizeText(string $value): string
    {
        return trim(strip_tags($value));
    }

    private function nullableSanitizedText(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return trim(strip_tags($value));
    }
}
