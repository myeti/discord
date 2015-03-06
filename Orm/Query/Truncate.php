<?php

namespace Discord\Orm\Query;

class Truncate implements Compilable
{

    use Clause\Table;

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