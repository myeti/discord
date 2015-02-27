<?php

namespace Discord\Orm\Persister;

use Discord\Orm\Persister;
use Discord\Orm\Query;

class Update extends Persister
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
        $this->sql = new Query\Update($entity->name);
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
     * @return int
     */
    protected function output($statement)
    {
        return $statement->rowCount();
    }

}