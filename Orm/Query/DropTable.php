<?php

namespace Discord\Orm\Query;

class DropTable implements Compilable
{

    use Clause\Table;
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