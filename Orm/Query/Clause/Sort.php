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

trait Sort
{

    /** @var array */
    protected $sort = [];


    /**
     * Sort data
     * @param $field
     * @param int $sort
     * @return $this
     */
    public function sort($field, $sort = SORT_ASC)
    {
        $this->sort[$field] = $sort;
        return $this;
    }


    /**
     * Compile sort clause into sql
     * @param $sql
     */
    protected function compileSort(&$sql)
    {
        if($this->sort) {
            $sort = [];
            foreach($this->sort as $field => $sens) {
                $sort[] = '`' . $field . '` ' . ($sens == SORT_DESC ? 'DESC' : 'ASC');
            }
            $sql[] = 'ORDER BY ' .implode(', ', $sort);
        }
    }

} 