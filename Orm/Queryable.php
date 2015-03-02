<?php

namespace Discord\Orm;

interface Queryable
{

    /**
     * Compile SQL
     *
     * @return array [sql, values]
     */
    public function compile();

} 