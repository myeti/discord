<?php

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