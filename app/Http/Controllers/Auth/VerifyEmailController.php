<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request, #[CurrentUser] User $user): RedirectResponse
    {
        if ($user->hasVerifiedEmail()) {
            session()->flash('flash-message', 'Your email is already verified.');

            return redirect()
                ->intended(route('profile.show', [
                    'username' => $user->username,
                ], absolute: false));
        }

        session()->flash('flash-message', 'Your email has been verified.');

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return to_route('profile.show', [
            'username' => $user->username,
        ]);
    }
}
