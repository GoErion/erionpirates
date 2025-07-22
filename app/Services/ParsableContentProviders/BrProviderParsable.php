<?php

namespace App\Services\ParsableContentProviders;

use App\Contracts\Services\ParsableContentProvider;

class BrProviderParsable implements ParsableContentProvider
{

    /**
     * Parse the given "parsable" content.
     */
    public function parse(string $content): string
    {
        return (string) preg_replace('/\n/','<br>',$content);
    }
}
