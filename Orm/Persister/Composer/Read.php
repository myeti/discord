<?php

namespace Discord\Orm\Persister\Composer;

use Discord\Orm\Persister\Composer;
use Discord\Orm\Query;

class Read extends Composer
{


    /**
     * Create inner compilable query
     *
     * @return Query\Select
     */
    protected function createQuery()
    {
        return new Query\Select($this->entity->name);
    }


    /**
     * Select fields
     *
     * @param $fields
     *
     * @return $this
     */
    public function select(...$fields)
    {
        $this->query->select(...$fields);

        return $this;
    }


    /**
     * Add where clause
     *
     * @param string $expression
     * @param mixed $value
     *
     * @return $this
     */
    public function where($expression, $value)
    {
        $this->query->where($expression, $value);

        return $this;
    }


    /**
     * Sort data
     *
     * @param $field
     * @param int $sort
     *
     * @return $this
     */
    public function sort($field, $sort = SORT_ASC)
    {
        $this->query->sort($field, $sort);

        return $this;
    }


    /**
     * Limit rows
     *
     * @param int $i
     * @param int $step
     *
     * @return $this
     */
    public function limit($i, $step = 0)
    {
        $this->query->limit($i, $step);

        return $this;
    }


    /**
     * Get one item
     *
     * @return object
     */
    public function first()
    {
        $this->limit(1);
        $list = $this->apply();

        return current($list);
    }

}