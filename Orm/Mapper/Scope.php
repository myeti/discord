<?php

namespace Discord\Orm\Mapper;

use Discord\Orm\Sql;

abstract class Scope
{

    /** @var \PDO */
    protected $pdo;

    /** @var Entity */
    protected $entity;

    /** @var Sql\Query */
    protected $sql;


    /**
     * Open scope
     *
     * @param \PDO $pdo
     * @param Entity $entity
     */
    public function __construct(\PDO $pdo, Entity $entity)
    {
        $this->pdo = $pdo;
        $this->entity = $entity;
    }


    /**
     * Apply scope query
     *
     * @return array|mixed
     */
    public function apply()
    {
        // compile query
        list($sql, $values) = $this->sql->compile();

        // prepare statement & execute
        if($sth = $this->pdo->prepare($sql)) {
            if($result = $sth->execute($values)) {
                return $result;
            }
        }

        // error
        $error = $this->pdo->errorInfo();
        throw new \PDOException('[' . $error[0] . '] ' . $error[2]);
    }

} 