<?php

namespace Discord\Orm\Builder\SQlite\Query;

use Discord\Orm\Query;

class Truncate extends Query\Truncate
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