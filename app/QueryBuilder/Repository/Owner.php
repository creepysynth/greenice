<?php

namespace App\QueryBuilder\Repository;

/**
 * Class Owner
 * @package App\QueryBuilder\Repository
 */
class Owner extends Query
{
    /**
     * @var string
     */
    protected $qualifier = 'user:%s';
}
