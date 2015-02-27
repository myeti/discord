<?php

namespace Discord\Orm;

abstract class Query implements Queryable
{

    /** @var string */
    protected $table;


    /**
     * Delete query
     *
     * @param string $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }


    /**
     * Compile SQL
     *
     * @return array [sql, values]
     */
    abstract public function compile();

} 