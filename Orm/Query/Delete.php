<?php

namespace Discord\Orm\Query;

class Delete implements Compilable
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
        $sql = $values = [];

        $sql[] = 'DELETE FROM `' . $this->table . '`';

        $this->compileWhere($sql, $values);

        $sql = implode("\n", $sql);

        return [$sql, $values];
    }

} 