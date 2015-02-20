<?php

namespace Discord\Orm\SQLite\Sql;

use Discord\Orm\Sql;

class Truncate extends Sql\Truncate
{

    /**
     * Generate sql & values
     * @return array [sql, values]
     */
    public function compile()
    {
        $sql =  'DELETE FROM `' . $this->table . '`;';

        return [$sql, []];
    }

} 