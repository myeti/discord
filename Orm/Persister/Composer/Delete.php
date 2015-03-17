<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
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