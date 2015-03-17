<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Orm\Persister;

use Discord\Orm\Query;

abstract class Composer
{

    /** @var \PDO */
    protected $pdo;

    /** @var Entity */
    protected $entity;

    /** @var Query\Compilable */
    protected $query;


    /**
     * Bind PDO to query
     *
     * @param \PDO $pdo
     * @param Entity $entity
     */
    public function __construct(\PDO $pdo, Entity $entity = null)
    {
        $this->pdo = $pdo;
        $this->entity = $entity;
        $this->query = $this->createQuery();
    }


    /**
     * Create inner compilable query
     *
     * @return Query\Compilable
     */
    abstract protected function createQuery();


    /**
     * Apply persister query
     *
     * @return object[]|int
     */
    public function apply()
    {
        // compile query
        list($sql, $values) = $this->query->compile();

        // prepare statement & execute
        if($statement = $this->pdo->prepare($sql) and $result = $statement->execute($values)) {
            return $this->output($statement);
        }

        // error
        $error = $this->pdo->errorInfo();
        throw new \PDOException('[' . $error[0] . '] ' . $error[2], $error[0]);
    }


    /**
     * Filter output result
     *
     * @param \PDOStatement $statement
     *
     *  @return object[]|int
     */
    protected function output(\PDOStatement $statement)
    {
        // collection
        if($statement->columnCount() > 0) {
            return ($this->entity and $this->entity->class)
                ? $statement->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $this->entity->class)
                : $statement->fetchAll(\PDO::FETCH_OBJ);
        }

        // action
        return $statement->rowCount();
    }

} 