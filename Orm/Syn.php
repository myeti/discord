<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Orm;

abstract class Syn
{

    /** @var Mappable */
    protected static $mapper;


    /**
     * Set/Get mapper
     *
     * @param Mappable $mapper
     *
     * @return Mappable
     */
    public static function mapper(Mappable $mapper = null)
    {
        if($mapper) {
            static::$mapper = $mapper;
        }
        if(!static::$mapper) {
            throw new \RuntimeException('You must set a valid mapper');
        }

        return static::$mapper;
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
    public static function all($entity, array $where = [], $sort = null, $limit = null)
    {
        return static::mapper()->all($entity, $where, $sort, $limit);
    }


    /**
     * Read one entity
     *
     * @param string $entity
     * @param array $where
     *
     * @return object
     */
    public static function one($entity, $where = [])
    {
        return static::mapper()->one($entity, $where);
    }


    /**
     * Create or update entity
     *
     * @param string $entity
     * @param array|object $data
     *
     * @return object
     */
    public static function save($entity, $data)
    {
        return static::mapper()->save($entity, $data);
    }


    /**
     * Delete entity
     *
     * @param string $entity
     * @param int|array $where
     *
     * @return bool
     */
    public static function wipe($entity, $where)
    {
        return static::mapper()->wipe($entity, $where);
    }


    /**
     * Generate inner PDO instance
     *
     * @return \PDO
     */
    public static function pdo()
    {
        return static::mapper()->pdo();
    }


    /**
     * Generate a create composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Create
     */
    public static function create($entity)
    {
        return static::mapper()->create($entity);
    }


    /**
     * Generate a read composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Read
     */
    public static function read($entity)
    {
        return static::mapper()->read($entity);
    }


    /**
     * Generate an update composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Update
     */
    public static function update($entity)
    {
        return static::mapper()->update($entity);
    }


    /**
     * Generate a delete composer
     *
     * @param string $entity
     *
     * @return Persister\Composer\Delete
     */
    public static function delete($entity)
    {
        return static::mapper()->delete($entity);
    }


    /**
     * MySQL adapter
     *
     * @param string $dbname
     * @param array $settings
     *
     * @return Mapper\MySQL
     */
    public static function MySQL($dbname, array $settings = [])
    {
        $mapper = new Mapper\MySQL($dbname, $settings);

        return static::mapper($mapper);
    }


    /**
     * SQLite adapter
     *
     * @param string $filename
     *
     * @return Mapper\SQLite
     */
    public static function SQLite($filename)
    {
        $mapper = new Mapper\SQLite($filename);

        return static::mapper($mapper);
    }

}