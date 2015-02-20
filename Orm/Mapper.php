<?php

namespace Discord\Orm;

class Mapper
{

    /** @var \PDO */
    protected $pdo;

    /** @var Mapper\Entity[] */
    protected $entities = [];

    /** @var array */
    protected $models = [];


    /**
     * New mapper
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * Register entity
     *
     * @param Mapper\Entity $entity
     *
     * @return $this
     */
    public function register(Mapper\Entity &$entity)
    {
        // has model
        if($entity->class) {
            $this->models[$entity->class] = $entity->name;
        }

        $this->entities[$entity->name] = $entity;

        return $this;
    }


    /**
     * Direct mapping to entity
     *
     * @param $class
     *
     * @return $this
     */
    public function map($class)
    {
        $entity = Mapper\Entity::of($class);
        $this->register($entity);

        return $this;
    }


    /**
     * Get registered entity
     *
     * @param string $name
     *
     * @return Mapper\Entity
     * @throws Mapper\UnknownEntity
     */
    public function entity($name)
    {
        // has model
        if(isset($this->models[$name])) {
            $name = $this->models[$name];
        }

        // entity does not exists
        if(!isset($this->entities[$name])) {
            throw new Mapper\UnknownEntity('Unknown entity "' . $name . '"');
        }

        return $this->entities[$name];
    }


    /**
     * Build entity structure into database
     * @todo
     *
     * @return bool
     */
    public function build()
    {

    }


    /**
     * Get read scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Read
     */
    public function read($name)
    {
        $entity = $this->entity($name);

        return new Mapper\Scope\Read($this->pdo, $entity);
    }


    /**
     * Get create scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Read
     */
    public function create($name)
    {
        $entity = $this->entity($name);

        return new Mapper\Scope\Create($this->pdo, $entity);
    }


    /**
     * Get edit scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Read
     */
    public function edit($name)
    {
        $entity = $this->entity($name);

        return new Mapper\Scope\Edit($this->pdo, $entity);
    }


    /**
     * Get drop scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Read
     */
    public function drop($name)
    {
        $entity = $this->entity($name);

        return new Mapper\Scope\Drop($this->pdo, $entity);
    }


    /**
     * Execute custom query
     *
     * @param string $sql
     * @param array $values
     *
     * @return array|mixed
     */
    public function query($sql, array $values = [])
    {
        $raw = new Mapper\Scope\Raw($this->pdo, $sql, $values);
        return $raw->apply();
    }

} 