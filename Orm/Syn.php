<?php

/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 */
namespace Discord\Orm;

abstract class Syn
{

    /** DB priority */
    const MASTER = 'master';
    const SLAVE = 'slave';

    /** @var Mapper[] */
    protected static $mappers = [];

    /** @var int */
    protected static $use = self::MASTER;


    /**
     * Plug custom mapper
     *
     * @param Mapper $mapper
     * @param string $as
     *
     * @return Mapper
     */
    public static function load(Mapper $mapper, $as = self::MASTER)
    {
        static::$mappers[$as] = $mapper;
        return static::mapper();
    }


    /**
     * MySQL driver constructor
     *
     * @param string $dbname
     * @param array $settings
     *
     * @return Mapper
     */
    public static function MySQL($dbname, array $settings = [])
    {
        $mapper = new MySQL($dbname, $settings);
        return static::load($mapper);
    }


    /**
     * SQLite driver constructor
     *
     * @param string $filename
     *
     * @return Mapper
     */
    public static function SQLite($filename)
    {
        $mapper = new SQLite($filename);
        return static::load($mapper);
    }


    /**
     * Get mapper
     *
     * @param string $as
     * @throws \LogicException
     *
     * @return Mapper
     */
    public static function mapper($as = null)
    {
        // set db
        if($as) {
            static::$use = $as;
        }

        // no db
        if(!isset(static::$mappers[static::$use])) {
            throw new \LogicException('No mapper "' . static::$use . '" registered.');
        }

        return static::$mappers[static::$use];
    }


    /**
     * Direct mapping to entity
     *
     * @param array $classes
     *
     * @return $this
     */
    public static function map(array $classes)
    {
        foreach($classes as $class) {
            static::mapper()->map($class);
        }

        return static::mapper();
    }



    /**
     * Get read scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Read
     */
    public static function read($name)
    {
        return static::mapper()->read($name);
    }


    /**
     * Helper : Read entities
     *
     * @param string $name
     * @param array $where
     * @param string $sort
     * @param int $limit
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
     * Helper : Read one entity
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
     * Get create scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Create
     */
    public static function create($name)
    {
        return static::mapper()->create($name);
    }


    /**
     * Get edit scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Edit
     */
    public static function edit($name)
    {
        return static::mapper()->edit($name);
    }


    /**
     * Helper : Create or edit
     *
     * @param string $name
     * @param object|array $data
     *
     * @return int|mixed
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
     * Get drop scope
     *
     * @param string $name
     *
     * @return Mapper\Scope\Read
     */
    public static function drop($name)
    {
        return static::mapper()->drop($name);
    }


    /**
     * Helper : Get drop scope
     *
     * @param string $name
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
     * Execute custom query
     *
     * @param string $sql
     * @param array $values
     *
     * @return array|mixed
     */
    public static function query($sql, array $values = [])
    {
        return static::mapper()->query($sql, $values);
    }

}