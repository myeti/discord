<?php

namespace Discord\Plop\Persister;

use Discord\Plop\Persister;
use Discord\Plop\Query;

class Create extends Persister
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
        $this->sql = new Query\Insert($entity->name);
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
            $this->sql->set($key, $value);
        }

        return $this;
    }


    /**
     * Filter output result
     *
     * @param PDOStatement $statement
     *
     *  @return object[]
     */
    protected function output($statement)
    {
        return $this->pdo->lastInsertId();
    }

}