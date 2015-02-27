<?php

namespace Discord\Orm;

class Mapper implements Mappable
{

    /** @var \PDO */
    public $pdo;

    /** @var Mapper\Entity */
    protected $entities = [];

    /** @var array */
    protected $classes = [];


    /**
     * Setup mapper
     *
     * @param \PDO $pdo
     * @param Mapper\Entity $entities
     */
    public function __construct(\PDO $pdo, Mapper\Entity ...$entities)
    {
        $this->pdo = $pdo;
        foreach($entities as $entity) {
            $this->register($entity);
        }
    }


    /**
     * Register entity
     *
     * @param Mapper\Entity $entity
     *
     * @return $this
     */
    public function register(Mapper\Entity $entity)
    {
        if($entity->class) {
            $this->classes[$entity->class] = $entity->name;
        }

        $this->entities[$entity->name] = $entity;

        return $this;
    }


    /**
     * Register class as entity
     *
     * @param string $class
     *
     * @return $this
     */
    public function map($class)
    {
        return $this->register(Mapper\Entity::of($class));
    }


    /**
     * Get registered entity
     *
     * @param string $name
     *
     * @return Mapper\Entity
     */
    public function entity($name)
    {
        if(isset($this->classes[$name])) {
            $name = $this->classes[$name];
        }

        if(isset($this->entities[$name])) {
            return $this->entities[$name];
        }

        throw new Error\UnknownEntity($name);
    }


    /**
     * Start safe transaction
     *
     * @return bool
     */
    public function transaction()
    {
        return $this->pdo->beginTransaction();
    }


    /**
     * Commit changes
     *
     * @return bool
     */
    public function commit()
    {
        return $this->pdo->commit();
    }


    /**
     * Rollback changes
     *
     * @return bool
     */
    public function rollback()
    {
        return $this->pdo->rollBack();
    }


    /**
     * Generate create scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Create
     */
    public function create($name)
    {
        $entity = $this->entity($name);
        return new Persister\Create($entity, $this->pdo);
    }


    /**
     * Generate read scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Read
     */
    public function read($name)
    {
        $entity = $this->entity($name);
        return new Persister\Read($entity, $this->pdo);
    }


    /**
     * Generate Update scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Update
     */
    public function update($name)
    {
        $entity = $this->entity($name);
        return new Persister\Update($entity, $this->pdo);
    }


    /**
     * Generate delete scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Delete
     */
    public function delete($name)
    {
        $entity = $this->entity($name);
        return new Persister\Delete($entity, $this->pdo);
    }


    /**
     * Generate custom scope
     *
     * @param string $query
     * @param array $values
     *
     * @return object[]|int
     */
    public function query($query, array $values = [])
    {
        $query = Persister\Query($this->pdo, $query, $values);
        return $query->apply();
    }

} 