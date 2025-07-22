<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\Locked;
use Livewire\Component;

trait HasLoadMore
{
    #[Locked]
    public int $perPage = 5;

    public function loadMore() : void
    {
        $this->perPage = $this->perPage > 100 ? 100 : ($this->perPage + 5);
    }
}
