<?php

namespace Discord\Orm\Query;

use Discord\Orm;

class DropTable extends Orm\Query
{

    use Clause\Where;


    /**
     * Compile SQL
     *
     * @return array [sql, values]
     */
    public function compile()
    {
        $sql =  'DROP TABLE `' . $this->table . '`;';

        return [$sql, []];
    }

}