<?php

namespace Discord\Orm;

interface Persistable
{

    /**
     * Get inner PDO instance
     * @return \PDO
     */
    public function pdo();

    /**
     * Register entity definition
     *
     * @param Persister\Entity $entity
     *
     * @return $this
     */
    public function register(Persister\Entity $entity);

    /**
     * Map class to $entity
     *
     * @param string $class
     *
     * @return $this
     */
    public function map($class);

    /**
     * Retrieve entity definition
     *
     * @param string $entity
     *
     * @return Persister\Entity
     * @throws \InvalidArgumentException
     */
    public function entity($entity);

    /**
     * Retrieve all entities definition
     *
     * @return Persister\Entity[]
     */
    public function entities();

    /**
     * Generate a create composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Create
     */
    public function create($entity);

    /**
     * Generate a read composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Read
     */
    public function read($entity);

    /**
     * Generate an update composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Update
     */
    public function update($entity);

    /**
     * Generate a delete composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Delete
     */
    public function delete($entity);

}