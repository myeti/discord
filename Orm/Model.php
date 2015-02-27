<?php

namespace Discord\Orm;

trait Model
{


    /**
     * Generate read scope
     *
     * @param string $name entity's name
     *
     * @return Persister\Read
     */
    public static function read()
    {
        return Syn::read(static::class);
    }


    /**
     * Read all entities
     *
     * @param array $where
     * @param string $sort
     * @param int|array $limit
     *
     * @return static[]
     */
    public static function all(array $where = [], $sort = null, $limit = null)
    {
        return Syn::all(static::class, $where, $sort, $limit);
    }


    /**
     * Read one entity
     *
     * @param array $where
     *
     * @return static
     */
    public static function one($where = [])
    {
        return Syn::one(static::class, $where);
    }


    /**
     * Generate create scope
     *
     * @return Persister\Create
     */
    public static function create()
    {
        return Syn::create(static::class);
    }


    /**
     * Create or update entity
     *
     * @return object
     */
    public static function update()
    {
        return Syn::update(static::class);
    }


    /**
     * Create or update entity
     *
     * @param array|object $data
     *
     * @return object
     */
    public static function save($data)
    {
        return Syn::save(static::class, $data);
    }


    /**
     * Generate delete scope
     *
     * @return Persister\Delete
     */
    public static function delete()
    {
        return Syn::drop(static::class);
    }


    /**
     * Delete entity
     *
     * @param int|array $where
     *
     * @return bool
     */
    public static function wipe($where)
    {
        return Syn::wipe(static::class, $where);
    }


    /**
     * Get many relation
     *
     * @param string $entity
     * @param string $foreign
     * @param string $local
     *
     * @return object[]
     */
    protected function _many($entity, $foreign, $local = 'id')
    {
        return Syn::all($entity, [$foreign => $this->{$local}]);
    }


    /**
     * Get one relation
     *
     * @param string $entity
     * @param string $local
     * @param string $foreign
     *
     * @return object
     */
    protected function _one($entity, $local, $foreign = 'id')
    {
        return Syn::one($entity, [$foreign => $this->{$local}]);
    }

} 