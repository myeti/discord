<?php

namespace Discord\Orm\Persister\Composer;

use Discord\Orm\Persister\Composer;
use Discord\Orm\Query;

class Delete extends Composer
{


    /**
     * Create inner compilable query
     *
     * @return Query\Delete
     */
    protected function createQuery()
    {
        return new Query\Delete($this->entity->name);
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
     * Filter output result
     *
     * @param \PDOStatement $statement
     *
     * @return int
     */
    protected function output($statement)
    {
        return $statement->rowCount();
    }

}