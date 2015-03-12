<?php

namespace Discord\Orm;

class Persister implements Persistable
{

    /** @var \PDO */
    protected $pdo;

    /** @var Persister\Entity[] */
    protected $entities = [];

    /** @var array */
    protected $classes = [];

    /** @var array */
    protected $composers = [
        'create'    => Persister\Composer\Create::class,
        'read'      => Persister\Composer\Read::class,
        'update'    => Persister\Composer\Update::class,
        'delete'    => Persister\Composer\Delete::class
    ];


    /**
     * Decorate PDO
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Get inner PDO instance
     * @return \PDO
     */
    public function pdo()
    {
        return $this->pdo;
    }


    /**
     * Register entity defition
     *
     * @param Persister\Entity $entity
     *
     * @return $this
     */
    public function register(Persister\Entity $entity)
    {
        if($entity->class) {
            $this->classes[$entity->class] = $entity->name;
        }

        $this->entities[$entity->name] = $entity;

        return $this;
    }


    /**
     * Map class to $entity
     *
     * @param string $class
     *
     * @return $this
     */
    public function map($class)
    {
        $entity = Persister\Entity::of($class);
        return $this->register($entity);
    }


    /**
     * Retrieve entity definition
     *
     * @param string $entity
     *
     * @return Persister\Entity
     * @throws \InvalidArgumentException
     */
    public function entity($entity)
    {
        if(isset($this->classes[$entity])) {
            $entity = $this->classes[$entity];
        }

        if(!isset($this->entities[$entity])) {
            throw new \InvalidArgumentException('Unknown entity ' . $entity);
        }

        return $this->entities[$entity];
    }


    /**
     * Retrieve all entities definition
     *
     * @return Persister\Entity[]
     */
    public function entities()
    {
        return $this->entities;
    }


    /**
     * Generate a create composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Create
     */
    public function create($entity)
    {
        $entity = $this->entity($entity);
        return new $this->composers['create']($this->pdo, $entity);
    }


    /**
     * Generate a read composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Read
     */
    public function read($entity)
    {
        $entity = $this->entity($entity);
        return new $this->composers['read']($this->pdo, $entity);
    }


    /**
     * Generate an update composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Update
     */
    public function update($entity)
    {
        $entity = $this->entity($entity);
        return new $this->composers['update']($this->pdo, $entity);
    }


    /**
     * Generate a delete composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Delete
     */
    public function delete($entity)
    {
        $entity = $this->entity($entity);
        return new $this->composers['delete']($this->pdo, $entity);
    }

}