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

class Create extends Composer
{


    /**
     * Create inner compilable query
     *
     * @return Query\Insert
     */
    protected function createQuery()
    {
        return new Query\Insert($this->entity->name);
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
     *  @return object[]
     */
    protected function output(\PDOStatement $statement)
    {
        return $this->pdo->lastInsertId();
    }
}