<?php

namespace App\Http\Controllers;

use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly ProfileRepository $profiles,
    ) {
    }

    public function index(Request $request): View
    {
        $userId = (int) $request->session()->get('auth_user_id');
        $user = $this->users->findById($userId);
        $profiles = [];
        $profileCount = 0;

        try {
            $profiles = $this->profiles->allForUser($userId);
            $profileCount = $this->profiles->countForUser($userId);
        } catch (Throwable $exception) {
            report($exception);

            session()->flash('error', 'We could not load your profile records right now.');
        }

        return view('dashboard.index', [
            'user' => $user,
            'profiles' => $profiles,
            'profileCount' => $profileCount,
        ]);
    }
}
