<?php

namespace Discord\Orm\Persister\Composer;

use Discord\Orm\Persister\Composer;
use Discord\Orm\Query;

class Update extends Composer
{


    /**
     * Create inner compilable query
     *
     * @return Query\Select
     */
    protected function createQuery()
    {
        return new Query\Update($this->entity->name);
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
     * Set data to edit
     *
     * @param array $data
     *
     * @return $this
     */
    public function with(array $data)
    {
        foreach($data as $key => $value) {
            $this->query->set($key, $value);
        }

        return $this;
    }


    /**
     * Filter output result
     *
     * @param \PDOStatement $statement
     *
     * @return int
     */
    protected function output(\PDOStatement $statement)
    {
        return $statement->rowCount();
    }

}