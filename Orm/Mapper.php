<?php

namespace Discord\Orm;

class Mapper implements Mappable
{

    /** @var Persistable */
    protected $persister;


    /**
     * Decorate persister
     *
     * @param Persistable $persister
     */
    public function __construct(Persistable $persister)
    {
        $this->persister = $persister;
    }


    /**
     * Get inner PDO instance
     * @return \PDO
     */
    public function pdo()
    {
        return $this->persister->pdo();
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
        $this->persister->register($entity);
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
        $this->persister->map($class);
        return $this;
    }


    /**
     * Retrieve entity definition
     *
     * @param string $entity
     *
     * @return Persister\Entity
     * @throws \InvalidArgumentException if incorrect entity name
     */
    public function entity($entity)
    {
        return $this->persister->entity($entity);
    }


    /**
     * Retrieve all entities definition
     *
     * @return Persister\Entity[]
     */
    public function entities()
    {
        return $this->persister->entities();
    }


    /**
     * Read all entities
     *
     * @param string $entity
     * @param array $where
     * @param string $sort
     * @param int|array $limit
     *
     * @return object[]
     */
    public function all($entity, array $where = [], $sort = null, $limit = null)
    {
        $read = $this->persister->read($entity);

        foreach($where as $condition => $value) {
            $read->where($condition, $value);
        }

        if($sort and is_array($sort)) {
            foreach($sort as $field => $sorting) {
                $read->sort($field, $sorting);
            }
        }
        elseif($sort) {
            $read->sort($sort);
        }

        if($limit and is_array($limit)) {
            $read->limit($limit[0], $limit[1]);
        }
        elseif($limit) {
            $read->limit($limit);
        }

        return $read->all();
    }


    /**
     * Read one entity
     *
     * @param string $entity
     * @param array $where
     *
     * @return object
     */
    public function one($entity, $where = [])
    {
        $read = $this->persister->read($entity);

        // id
        if(is_int($where) or is_string($where)) {
            $id = $this->persister->entity($entity)->id;
            $where = [$id => $where];
        }

        foreach($where as $condition => $value) {
            $read->where($condition, $value);
        }

        return $read->one();
    }


    /**
     * Create or update entity
     *
     * @param string $entity
     * @param array|object $data
     *
     * @return object
     */
    public function save($entity, $data)
    {
        // force array
        if(is_object($data)) {
            $data = (array)$data;
        }
        elseif(!is_array($data)) {
            throw new \InvalidArgumentException('Mapper::save() must receive an array or object');
        }

        // retrieve id field
        $id = $this->persister->entity($entity)->id;

        // update
        if(!empty($data[$id])) {
            $edit = $this->persister->update($entity);
            $edit->where($id, $data[$id]);
            $edit->with($data);
            return $edit->apply();
        }

        // create
        return $this->persister->create($entity)->with($data)->apply();
    }


    /**
     * Delete entity
     *
     * @param string $entity
     * @param int|array $where
     *
     * @return bool
     */
    public function wipe($entity, $where)
    {
        // id
        if(!is_array($where)) {
            $where = ['id' => $where];
        }

        $delete = $this->persister->delete($entity);
        foreach($where as $condition => $value) {
            $delete->where($condition, $value);
        }

        return $delete->apply();
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
        return $this->persister->create($entity);
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
        return $this->persister->read($entity);
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
        return $this->persister->update($entity);
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
        return $this->persister->delete($entity);
    }

}