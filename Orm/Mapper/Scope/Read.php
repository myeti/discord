<?php

namespace Discord\Orm\Mapper\Scope;

use Discord\Orm\Mapper;
use Discord\Orm\Sql;

class Read extends Mapper\Scope
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
        $this->sql = new Sql\Select($entity->name);
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
     * Apply scope query
     *
     * @return array|false
     */
    public function apply()
    {
        // compile query
        list($sql, $values) = $this->sql->compile();

        // prepare statement
        if($sth = $this->pdo->prepare($sql)) {

            // execute it
            $sth->execute($values);

            // return models or objects
            return ($this->entity->class)
                ? $sth->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->entity->class)
                : $sth->fetchAll(\PDO::FETCH_OBJ);
        }

        return false;
    }


    /**
     * Get list
     *
     * @return array
     */
    public function all()
    {
        return $this->apply();
    }


    /**
     * Get one item
     *
     * @return object
     */
    public function one()
    {
        $this->limit(1);
        $list = $this->all();

        return current($list);
    }

}