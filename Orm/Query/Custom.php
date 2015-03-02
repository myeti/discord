<?php

namespace Discord\Orm\Query;

class Custom implements Queryable
{

    /** @var string */
    public $sql;

    /** @var array */
    public $values = [];


    /**
     * Create raw query
     *
     * @param string $sql
     * @param array $values
     */
    public function __construct($sql, array $values = [])
    {
        $this->sql = $sql;
        $this->values = $values;
    }


    /**
     * Compile SQL
     *
     * @return array [sql, values]
     */
    public function compile()
    {
        return [$this->sql, $this->values];
    }

} 