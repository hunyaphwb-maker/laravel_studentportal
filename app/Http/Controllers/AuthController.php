<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PDOException;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepository $users,
    ) {
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $userId = $this->users->create([
                'name' => $this->sanitizeText($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'password' => password_hash($validated['password'], PASSWORD_DEFAULT),
            ]);
        } catch (PDOException $exception) {
            if ($this->users->isDuplicateEmail($exception)) {
                return back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors(['email' => 'That email is already registered.']);
            }

            report($exception);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'We could not complete your registration right now.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Something went wrong while creating your account.');
        }

        $user = $this->users->findById($userId);

        $request->session()->regenerate();
        $this->storeAuthenticatedUser($request, $user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Registration successful. Welcome to your dashboard.');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        try {
            $user = $this->users->findByEmail(strtolower(trim($validated['email'])));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput($request->except('password'))
                ->with('error', 'We could not process your login right now.');
        }

        if (! $user || ! password_verify($validated['password'], $user['password'])) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['email' => 'Invalid email or password.']);
        }

        $request->session()->regenerate();
        $this->storeAuthenticatedUser($request, $user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Welcome back, '.$user['name'].'!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }

    private function sanitizeText(string $value): string
    {
        return trim(strip_tags($value));
    }

    private function storeAuthenticatedUser(Request $request, ?array $user): void
    {
        if (! $user) {
            return;
        }

        $request->session()->put([
            'auth_user_id' => (int) $user['id'],
            'auth_user_name' => $user['name'],
            'auth_user_email' => $user['email'],
            'last_activity' => time(),
        ]);
    }
}
