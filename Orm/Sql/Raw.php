<?php

namespace Discord\Orm\Sql;

use Discord\Orm\Sql;

class Raw extends Query
{

    /** @var string */
    protected $sql;

    /** @var array */
    protected $values = [];


    /**
     * New raw user query
     * @param string $sql
     * @param array $values
     */
    public function __construct($sql, array $values = [])
    {
        $this->sql = $sql;
        $this->values = $values;
    }


    /**
     * Generate sql & values
     * @return array [sql, values]
     */
    public function compile()
    {
        return [$this->sql, $this->values];
    }

}