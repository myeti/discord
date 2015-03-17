<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
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