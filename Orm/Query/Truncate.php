<?php

namespace Discord\Orm\Query;

use Discord\Orm;

class Truncate extends Orm\Query
{

    /**
     * Compile SQL
     *
     * @return array [sql, values]
     */
    public function compile()
    {
        $sql =  'TRUNCATE `' . $this->table . '`;';

        return [$sql, []];
    }

}