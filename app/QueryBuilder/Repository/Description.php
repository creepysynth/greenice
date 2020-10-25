<?php

namespace App\QueryBuilder\Repository;

/* Before refactoring
class Description
{
    private $qualifier = '+in:description';

    public function handle($request, \Closure $next)
    {
        if (request()->isNotFilled('description'))
        {
            return $next($request);
        }

        $query = $next($request);

        $query[] = request()->get('description') . $this->qualifier;

        return $query;
    }
}
*/

/* After refactoring */
class Description extends Query
{
    /**
     * @var string
     */
    protected $qualifier = '%s+in:description';
}
