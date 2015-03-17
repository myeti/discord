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

use Discord\Orm;

class Update implements Compilable
{

    use Clause\Where;

    /** @var string */
    protected $table;

    /** @var array */
    protected $data;


    /**
     * Set table
     *
     * @param string $table
     * @param array $data
     */
    public function __construct($table, array $data = [])
    {
        $this->table = $table;
        $this->data = $data;
    }


    /**
     * Select field
     *
     * @param string $field
     * @param mixed $value
     *
     * @return $this
     */
    public function set($field, $value)
    {
        $this->data[$field] = $value;
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

        $sql[] = 'UPDATE `' . $this->table . '`';
        $fields = [];
        foreach($this->data as $field => $value) {
            $fields[] = '`' . $field . '` = ?';
            $values[] = $value;
        }
        $sql[] = 'SET ' . implode(', ', $fields);

        $this->compileWhere($sql, $values);

        $sql = implode("\n", $sql);

        return [$sql, $values];
    }

} 