<?php

namespace App\Services\ParsableContentProviders;

use App\Contracts\Services\ParsableContentProvider;

class StripProviderParsable implements ParsableContentProvider
{

    /**
     * {@inheritDoc}
     */
    public function parse(string $content): string
    {
        return e($content);
    }
}
