<?php

/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 */
namespace Discord\Orm\Sql;

abstract class Query
{

    /** @var string */
    protected $table;


    /**
     * Set table
     * @param string $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }


    /**
     * Generate sql & values
     * @return array [sql, values]
     */
    abstract public function compile();


    /**
     * Print SQL only
     * @return string
     */
    public function __toString()
    {
        list($sql,) = $this->compile();
        return $sql;
    }

} 