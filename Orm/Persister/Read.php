<?php

namespace Discord\Orm\Persister;

use Discord\Orm\Persister;
use Discord\Orm\Query;

class Read extends Persister
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
        $this->sql = new Query\Select($entity->name);
    }


    /**
     * Select fields
     *
     * @param $fields
     *
     * @return $this
     */
    public function select(...$fields)
    {
        $this->sql->select(...$fields);

        return $this;
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
     * Sort data
     *
     * @param $field
     * @param int $sort
     *
     * @return $this
     */
    public function sort($field, $sort = SORT_ASC)
    {
        $this->sql->sort($field, $sort);

        return $this;
    }


    /**
     * Limit rows
     *
     * @param int $i
     * @param int $step
     *
     * @return $this
     */
    public function limit($i, $step = 0)
    {
        $this->sql->limit($i, $step);

        return $this;
    }


    /**
     * Get one item
     *
     * @return object
     */
    public function first()
    {
        $this->limit(1);
        $list = $this->apply();

        return current($list);
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
        // return models or objects
        return ($this->entity->class)
            ? $sth->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->entity->class)
            : $sth->fetchAll(\PDO::FETCH_OBJ);
    }

}