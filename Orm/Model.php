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

trait Model
{


    /**
     * Get read scope
     *
     * @return Mapper\Scope\Read
     */
    public static function read()
    {
        return Syn::read(static::class);
    }


    /**
     * Get many entities
     *
     * @param array $where
     * @param int $sort
     * @param mixed $limit
     *
     * @return static[]
     */
    public static function all(array $where = [], $sort = null, $limit = null)
    {
        return Syn::all(static::class, $where, $sort, $limit);
    }


    /**
     * Get one entity
     *
     * @param $where
     *
     * @return static
     */
    public static function one($where)
    {
        return Syn::one(static::class, $where);
    }

    /**
     * Get create scope
     *
     * @return Mapper\Scope\Create
     */
    public static function create()
    {
        return Syn::create(static::class);
    }


    /**
     * Get edit scope
     *
     * @return Mapper\Scope\Edit
     */
    public static function edit()
    {
        return Syn::edit(static::class);
    }


    /**
     * Save entity
     *
     * @param mixed $data
     *
     * @return int|bool
     */
    public static function save($data)
    {
        return Syn::save(static::class, $data);
    }


    /**
     * Get drop scope
     *
     * @return Mapper\Scope\Read
     */
    public static function drop()
    {
        return Syn::drop(static::class);
    }


    /**
     * Drop entity
     *
     * @param $where
     *
     * @return int
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