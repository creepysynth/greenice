<?php

namespace App\QueryBuilder\Repository;

/**
 * Class Name
 * @package App\QueryBuilder\Repository
 */
class Name extends Query
{
    /**
     * @var string
     */
    protected $qualifier = '%s+in:name';
}
