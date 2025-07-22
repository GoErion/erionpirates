<?php

namespace App\Livewire\Concerns;

use Livewire\Component;

trait NeedsVerifiedEmail
{
    public function doesNotHaveVerifiedEmail(): bool
    {
        if (auth()->user()?->hasVerifiedEmail())
        {
            return false;
        }
        session()->flash('flash-message', 'You must verify your email address before you can continue.');

        $this->redirectRoute('verification.notice', navigate: true);

        return true;
    }
}
