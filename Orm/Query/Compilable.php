<?php

namespace Discord\Orm\Query;

interface Compilable
{

    /**
     * Compile query into SQL
     *
     * @return array [sql, values]
     */
    public function compile();

} 