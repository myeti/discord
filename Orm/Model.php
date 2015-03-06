<?php

namespace Discord\Orm;

trait Model
{

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
     * Generate a create composer
     *
     * @return Persister\Composer\Create
     */
    public static function create()
    {
        return Syn::create(static::class);
    }


    /**
     * Generate a read composer
     *
     * @return Persister\Composer\Read
     */
    public static function read()
    {
        return Syn::read(static::class);
    }


    /**
     * Generate an update composer
     *
     * @return Persister\Composer\Update
     */
    public static function update()
    {
        return Syn::update(static::class);
    }


    /**
     * Generate a delete composer
     *
     * @return Persister\Composer\Delete
     */
    public static function delete()
    {
        return Syn::delete(static::class);
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