<?php

namespace Discord\Orm\Persister;

use Discord\Orm\Persister;
use Discord\Orm\Query;

class Query extends Persister
{

    /**
     * Open scope
     *
     * @param \PDO $pdo
     * @param Mapper\Entity $entity
     */
    public function __construct(\PDO $pdo, $sql, array $values = [])
    {
        parent::__construct($entity, $pdo);
        $this->sql = new Query\Custom($sql, $values);
    }

}