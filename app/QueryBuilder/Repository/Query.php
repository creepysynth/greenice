<?php

namespace App\QueryBuilder\Repository;

use Closure;
use Illuminate\Support\Str;

/**
 * Class Query
 * @package App\QueryBuilder\Repository
 */
abstract class Query
{
    /**
     * Handle an incoming request
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the request parameter name from the current class name
        $parameter = $this->filterName();

        if (request()->isNotFilled($parameter))
        {
            return $next($request);
        }

        $query = $next($request);

        $query[] = sprintf($this->qualifier, request()->get($parameter));

        return $query;
    }

    /**
     * Creates a string with the snake case name of the current class
     *
     * @return string
     */
    protected function filterName()
    {
        return Str::snake(class_basename($this));
    }
}
