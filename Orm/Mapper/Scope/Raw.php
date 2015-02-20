<?php

namespace Discord\Orm\Mapper\Scope;

use Discord\Orm\Mapper;
use Discord\Orm\Sql;

class Raw extends Mapper\Scope
{

    /**
     * Open raw scope

     * @param array $values
     * @internal param Mapper\Entity $entity
     */
    public function __construct(\PDO $pdo, $sql, array $values = [])
    {
        $this->pdo = $pdo;
        $this->sql = new Sql\Raw($sql, $values);
    }

}