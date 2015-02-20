<?php

namespace Discord\Orm\Sql;

use Discord\Orm\Sql;

class Drop extends Query
{

    /**
     * Generate sql & values
     * @return array [sql, values]
     */
    public function compile()
    {
        $sql =  'DROP TABLE `' . $this->table . '`;';

        return [$sql, []];
    }

}