<?php

namespace App\Http\Filters;

class FilmsFilter extends QueryFilter
{
    /**
     * @param string $status
     */
    public function status(string $status): void
    {
        $this->builder->where('status', '=', $status);
    }

    /**
     * @param string $genre
     */
    public function genre(string $genre): void
    {
        $this->builder->where('genre', '=', $genre);
    }
}
