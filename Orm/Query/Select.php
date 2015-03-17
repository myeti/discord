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

class Select implements Compilable
{

    use Clause\Where;
    use Clause\Sort;
    use Clause\Limit;

    /** @var string */
    protected $table;

    /** @var array */
    protected $fields = [];


    /**
     * Set table
     *
     * @param string $table
     */
    public function __construct($table, array $fields = [])
    {
        if(!$fields) {
            $fields = ['*'];
        }

        $this->table = $table;
        $this->fields = $fields;
    }


    /**
     * Select fields
     *
     * @param $fields
     *
     * @return $this
     */
    public function select(...$fields)
    {
        $this->fields = $fields;
        return $this;
    }


    /**
     * Compile SQL
     *
     * @return array [sql, values]
     */
    public function compile()
    {
        $sql = $values = [];

        $sql[] = 'SELECT ' . implode(', ', $this->fields);
        $sql[] = 'FROM `' . $this->table . '`';

        $this->compileWhere($sql, $values);
        $this->compileSort($sql);
        $this->compileLimit($sql);

        $sql = implode("\n", $sql);

        return [$sql, $values];
    }

}