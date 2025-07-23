<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function destroy(): RedirectResponse
    {
        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return back();
    }
}
