<?php

namespace Discord\Orm;

abstract class Syn
{

    /** DB priority */
    const MASTER = 'master';
    const SLAVE = 'slave';

    /** @var Manageable[] */
    protected static $managers = [];

    /** @var int */
    protected static $use = self::MASTER;


    /**
     * Plug custom manager
     *
     * @param Manageable $manager
     * @param string $as
     *
     * @return Manageable
     */
    public static function load(Manageable $manager, $as = self::MASTER)
    {
        static::$managers[$as] = $manager;
        return static::manager();
    }


    /**
     * MySQL driver constructor
     *
     * @param string $dbname
     * @param array $settings
     *
     * @return Manager\MySQL
     */
    public static function MySQL($dbname, array $settings = [])
    {
        $manager = new Manager\MySQL($dbname, $settings);
        return static::load($manager);
    }


    /**
     * SQLite driver constructor
     *
     * @param string $filename
     *
     * @return Manager\SQLite
     */
    public static function SQLite($filename)
    {
        $manager = new Manager\SQLite($filename);
        return static::load($manager);
    }


    /**
     * Get manager
     *
     * @param string $as
     * @throws \LogicException
     *
     * @return Manageable
     */
    public static function manager($as = null)
    {
        // set db
        if($as) {
            static::$use = $as;
        }

        // no db
        if(!isset(static::$managers[static::$use])) {
            throw new Error\UnknownManager('No manager "' . static::$use . '" loaded.');
        }

        return static::$managers[static::$use];
    }


    /**
     * Register classes as entities
     *
     * @param array $classes
     *
     * @return Manageable
     */
    public static function map(array $classes)
    {
        foreach($classes as $class) {
            static::manager()->map($class);
        }

        return static::manager();
    }



    /**
     * Start safe transaction
     *
     * @return bool
     */
    public static function transaction()
    {
        return static::manager()->transaction();
    }



    /**
     * Commit changes
     *
     * @return bool
     */
    public static function commit()
    {
        return static::manager()->commit();
    }



    /**
     * Rollback changes
     *
     * @return bool
     */
    public static function rollback($name)
    {
        return static::manager()->rollback($name);
    }



    /**
     * Generate read scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Read
     */
    public static function read($name)
    {
        return static::manager()->read($name);
    }


    /**
     * Read all entities
     *
     * @param string $name
     * @param array $where
     * @param string $sort
     * @param int|array $limit
     *
     * @return object[]
     */
    public static function all($name, array $where = [], $sort = null, $limit = null)
    {
        $read = static::read($name);

        foreach($where as $cond => $value) {
            $read->where($cond, $value);
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
     * @param string $name
     * @param array $where
     *
     * @return object
     */
    public static function one($name, $where = [])
    {
        $read = static::read($name);

        // id
        if(is_int($where) or is_string($where)) {
            $where = ['id' => $where];
        }

        foreach($where as $cond => $value) {
            $read->where($cond, $value);
        }

        return $read->one();
    }


    /**
     * Generate create scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Create
     */
    public static function create($name)
    {
        return static::manager()->create($name);
    }


    /**
     * Generate Update scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Update
     */
    public static function update($name)
    {
        return static::manager()->update($name);
    }


    /**
     * Create or update entity
     *
     * @param string $name
     * @param array|object $data
     *
     * @return object
     */
    public static function save($name, $data)
    {
        if(is_object($data)) {
            $data = (array)$data;
        }
        elseif(!is_array($data)) {
            throw new \InvalidArgumentException('$data must be an array or object');
        }

        // edit
        if(!empty($data['id'])) {
            $edit = static::edit($name);
            $edit->where('id', $data['id']);
            $edit->with($data);
            return $edit->apply();
        }

        // create
        return static::create($name)->with($data)->apply();
    }


    /**
     * Generate delete scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Delete
     */
    public static function delete($name)
    {
        return static::manager()->delete($name);
    }


    /**
     * Delete entity
     *
     * @param string $name
     * @param int|array $where
     *
     * @return bool
     */
    public static function wipe($name, $where)
    {
        if(!is_array($where)) {
            $where = ['id' => $where];
        }

        $drop = static::drop($name);
        foreach($where as $cond => $value) {
            $drop->where($cond, $value);
        }

        return $drop->apply();
    }


    /**
     * Generate custom scope
     *
     * @param string $query
     * @param array $values
     *
     * @return mixed
     */
    public static function query($query, array $values = [])
    {
        return static::manager()->query($query, $values);
    }

}