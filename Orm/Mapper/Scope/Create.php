<?php

namespace Discord\Orm\Mapper\Scope;

use Discord\Orm\Mapper;
use Discord\Orm\Sql;

class Create extends Mapper\Scope
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
        $this->sql = new Sql\Insert($entity->name);
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
     * Apply scope query
     *
     * @return array|false
     */
    public function apply()
    {
        parent::apply();

        return $this->pdo->lastInsertId();
    }

}