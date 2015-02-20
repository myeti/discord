<?php

namespace Discord\Orm\Sql;

use Discord\Orm\Sql;

class Truncate extends Query
{

    /**
     * Generate sql & values
     * @return array [sql, values]
     */
    public function compile()
    {
        $sql =  'TRUNCATE `' . $this->table . '`;';

        return [$sql, []];
    }

}