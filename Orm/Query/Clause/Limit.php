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

trait Limit
{

    /** @var string */
    protected $limit;


    /**
     * Limit rows
     * @param int $i
     * @param int $step
     * @return $this
     */
    public function limit($i, $step = 0)
    {
        $this->limit = $i;
        if($step) {
            $this->limit .= ', ' . $step;
        }
        return $this;
    }


    /**
     * Compile limit clause into sql
     * @param $sql
     */
    protected function compileLimit(&$sql)
    {
        if($this->limit) {
            $sql[] = 'LIMIT ' . $this->limit;
        }
    }

} 