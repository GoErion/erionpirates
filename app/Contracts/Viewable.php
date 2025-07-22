<?php

namespace App\Contracts;

interface Viewable
{
    /**
     * Increment the views for the given IDs.
     *
     * @param  array<int, int>  $ids
     */
    public static function incrementViews(array $ids): void;
}
