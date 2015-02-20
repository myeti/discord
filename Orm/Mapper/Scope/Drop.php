<?php

namespace Discord\Orm\Mapper\Scope;

use Discord\Orm\Mapper;
use Discord\Orm\Sql;

class Drop extends Mapper\Scope
{

    /**
     * Open scope
     *
     * @param \PDO $pdo
     * @param Mapper\Entity $entity
     */
    public function __construct(\PDO $pdo, Mapper\Entity $entity)
    {
        parent::__construct($pdo, $entity);
        $this->sql = new Sql\Delete($entity->name);
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

}