<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(#[CurrentUser] User $user): RedirectResponse | View
    {
        return $user->hasVerifiedEmail() ? redirect()->intended(route('profile.show', [
            'username' => $user->username,
        ],
        absolute: false
        )): view('auth.verify-email');
    }
}
