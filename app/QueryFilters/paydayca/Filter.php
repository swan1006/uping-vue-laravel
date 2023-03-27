<?php

namespace App\QueryFilters\paydayca;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class Filter
{

    public function handle(
        $builder,
        $values,
        $buyerTierID,
        $condition,
        Closure $next
    )
    {
        $builder = $next(
            $builder,
            $values,
            $buyerTierID,
            $condition
        );

        return $this->applyFilters(
            $builder,
            $values,
            $buyerTierID,
            $condition
        );

    }

    protected abstract function applyFilters(
        $builder,
        $values,
        $buyerTierID,
        $condition
    );

    protected function filterName()
    {
//        dd(Str::snake(class_basename('DateOfBirth')));
        return Str::snake(class_basename($this));
    }

}
