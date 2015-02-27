<?php

namespace Discord\Orm;

interface Persistable
{

    /**
     * Setup persister using pdo and entitys
     *
     * @param Mapper\Entity $entity
     * @param \PDO $pdo
     */
    public function __construct(Mapper\Entity $entity, \PDO $pdo)

    /**
     * Endpoint : apply persistance
     *
     * @return mixed
     */
    public function apply();

} 