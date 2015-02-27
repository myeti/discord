<?php

namespace Discord\Orm\Persister;

use Discord\Orm\Persister;
use Discord\Orm\Query;

class Delete extends Persister
{

    /**
     * Open scope
     *
     * @param \PDO $pdo
     * @param Mapper\Entity $entity
     */
    public function __construct(Mapper\Entity $entity, \PDO $pdo)
    {
        parent::__construct($entity, $pdo);
        $this->sql = new Query\Delete($entity->name);
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
        $this->sql->where($expression, $value);

        return $this;
    }


    /**
     * Filter output result
     *
     * @param PDOStatement $statement
     *
     * @return int
     */
    protected function output($statement)
    {
        return $statement->rowCount();
    }

}