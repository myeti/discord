<?php

namespace Discord\Orm;

class Builder implements Buildable
{

    /** @var Persistable */
    protected $persister;

    /** @var array */
    protected $queries = [
        'build' => Query\CreateTable::class,
        'drop'  => Query\DropTable::class
    ];


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
     * Build entity structure
     *
     * @param Persister\Entity|string $entity
     *
     * @return bool
     */
    public function build($entity)
    {
        if(!$entity instanceof Persister\Entity) {
            $entity = $this->persister->entity($entity);
        }

        $query = new $this->queries['build']($entity->name);

        foreach($entity->fields as $field) {
            $query->set($field->name, $field->type, $field->null, $field->default, $field->primary);
        }

        list($sql) = $query->compile();

        // prepare statement & execute
        if($this->persister->pdo()->exec($sql)) {
            return true;
        }

        // error
        $error = $this->persister->pdo()->errorInfo();
        throw new \PDOException('[' . $error[0] . '] ' . $error[2], $error[0]);
    }


    /**
     * Build all entities structure
     *
     * @return bool
     */
    public function generate()
    {
        $state = true;
        foreach($this->persister->entities() as $entity) {
            $state &= $this->build($entity->name);
        }

        return $state;
    }


    /**
     * Destroy entity structures
     *
     * @param string $entity
     *
     * @return bool
     */
    public function drop($entity)
    {
        if(!$entity instanceof Persister\Entity) {
            $entity = $this->persister->entity($entity);
        }

        $query = new $this->queries['drop']($entity->name);
        list($sql) = $query->compile();

        // prepare statement & execute
        if($this->persister->pdo()->exec($sql)) {
            return true;
        }

        // error
        $error = $this->persister->pdo()->errorInfo();
        throw new \PDOException('[' . $error[0] . '] ' . $error[2], $error[0]);
    }


    /**
     * Destroy all entities structures
     *
     * @param Persister\Entity $entity
     *
     * @return bool
     */
    public function destroy()
    {
        $state = true;
        foreach($this->persister->entities() as $entity) {
            $state &= $this->drop($entity->name);
        }

        return $state;
    }

}