<?php

namespace Discord\Orm\Query\Clause;

trait Table
{

    /** @var string */
    protected $table;


    /**
     * Define table scope
     *
     * @param string $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

}