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

interface Mappable extends Persistable
{

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
    public function all($name, array $where = [], $sort = null, $limit = null);

    /**
     * Read one entity
     *
     * @param string $name
     * @param array $where
     *
     * @return object
     */
    public function one($name, $where = []);

    /**
     * Create or update entity
     *
     * @param string $name
     * @param array|object $data
     *
     * @return object
     */
    public function save($name, $data);

    /**
     * Delete entity
     *
     * @param string $name
     * @param int|array $where
     *
     * @return bool
     */
    public function wipe($name, $where);

}