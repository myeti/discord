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

interface Buildable
{

    /**
     * Build entity structure
     *
     * @param string $entity
     *
     * @return bool
     */
    public function build($entity);


    /**
     * Build all entities structure
     *
     * @return bool
     */
    public function generate();


    /**
     * Destroy entity structures
     *
     * @param string $entity
     *
     * @return bool
     */
    public function drop($entity);


    /**
     * Destroy all entities structures
     *
     * @param Persister\Entity $entity
     *
     * @return bool
     */
    public function destroy();

} 