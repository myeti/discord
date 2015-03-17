<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
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