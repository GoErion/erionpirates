<?php

namespace App\Contracts\Services;

interface ParsableContentProvider
{
    /**
     * Parse the given "parsable" content.
     */
    public function parse(string $content): string;
}
