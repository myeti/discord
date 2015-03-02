<?php

namespace Discord\Orm;

abstract class Persister implements Persistable
{

    /** @var \PDO */
    public $pdo;

    /** @var Mapper\Entity */
    public $entity;

    /** @var Query\Compilable */
    public $sql;


    /**
     * Setup persister using pdo and entitys
     *
     * @param Mapper\Entity $entity
     * @param \PDO $pdo
     */
    public function __construct(Mapper\Entity $entity, \PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->entity = $entity;
    }

    /**
     * Endpoint : apply persistance
     *
     * @return object[]|int
     */
    public function apply()
    {
        // compile query
        list($sql, $values) = $this->sql->compile();

        // prepare statement & execute
        if($sth = $this->pdo->prepare($sql)) {
            if($result = $sth->execute($values)) {
                return $this->output($sth);
            }
        }

        // error
        $error = $this->pdo->errorInfo();
        throw new \PDOException('[' . $error[0] . '] ' . $error[2], $error[0]);
    }


    /**
     * Filter output result
     *
     * @param PDOStatement $statement
     *
     *  @return object[]|int
     */
    protected function output($statement)
    {
        // collection
        if($statement->columnCount() > 0) {
            return ($this->entity->class)
                ? $sth->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->entity->class)
                : $sth->fetchAll(\PDO::FETCH_OBJ);
        }

        return $statement->rowCount();
    }

} 