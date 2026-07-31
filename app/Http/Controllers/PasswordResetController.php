<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetLinkMail;
use App\Repositories\PasswordResetTokenRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class PasswordResetController extends Controller
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly PasswordResetTokenRepository $tokens,
    ) {
    }

    public function showForgotForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $email = strtolower(trim($validated['email']));

        try {
            $user = $this->users->findByEmail($email);

            if ($user) {
                $plainToken = Str::random(64);
                $hashedToken = hash('sha256', $plainToken);

                $this->tokens->upsertToken($email, $hashedToken);

                $resetUrl = route('password.reset', [
                    'token' => $plainToken,
                    'email' => $email,
                ]);

                Mail::to($email)->send(new PasswordResetLinkMail($resetUrl));
            }
        } catch (Throwable $exception) {
            report($exception);

            return back()->with('error', 'We could not send the reset email right now.');
        }

        return back()->with(
            'success',
            'If an account exists for that email, a password reset link has been sent.'
        );
    }

    public function showResetForm(Request $request, string $token): View
    {
        $email = (string) $request->query('email', '');

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = strtolower(trim($validated['email']));
        $hashedToken = hash('sha256', $validated['token']);

        try {
            $record = $this->tokens->findToken($email);

            if (! $record || ! hash_equals((string) $record['token'], $hashedToken)) {
                return back()->withErrors(['email' => 'Invalid or expired reset link.'])->withInput();
            }

            $createdAt = strtotime((string) $record['created_at']);
            $expiresInSeconds = 60 * 60;

            if ($createdAt === false || (time() - $createdAt) > $expiresInSeconds) {
                $this->tokens->deleteForEmail($email);

                return back()->withErrors(['email' => 'Invalid or expired reset link.'])->withInput();
            }

            $this->users->updatePasswordByEmail($email, password_hash($validated['password'], PASSWORD_DEFAULT));
            $this->tokens->deleteForEmail($email);
        } catch (Throwable $exception) {
            report($exception);

            return back()->with('error', 'We could not reset your password right now.');
        }

        return redirect()
            ->route('login')
            ->with('success', 'Password updated. You can now log in.');
    }
}

