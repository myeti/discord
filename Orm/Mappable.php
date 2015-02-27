<?php

namespace Discord\Orm;

/**
 * Define CRUD methods used by the mapper
 */
interface Mappable
{

    /**
     * Register entity
     *
     * @param Mapper\Entity $entity
     *
     * @return $this
     */
    public function register(Mapper\Entity $entity);

    /**
     * Register class as entity
     *
     * @param string $class
     *
     * @return $this
     */
    public function map($class);

    /**
     * Build database structure
     *
     * @return bool
     */
    public function build();

    /**
     * Get registered entity
     *
     * @param string $name
     *
     * @return Mapper\Entity
     */
    public function entity($name);

    /**
     * Start safe transaction
     *
     * @return bool
     */
    public function transaction();

    /**
     * Commit changes
     *
     * @return bool
     */
    public function commit();

    /**
     * Rollback changes
     *
     * @return bool
     */
    public function rollback();

    /**
     * Generate create scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Create
     */
    public function create($name);

    /**
     * Generate read scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Read
     */
    public function read($name);

    /**
     * Generate Update scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Update
     */
    public function update($name);

    /**
     * Generate delete scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Delete
     */
    public function delete($name);

    /**
     * Generate custom scope
     *
     * @param string $query
     * @param array $values
     *
     * @return mixed
     */
    public function query($query, array $values = []);

} 