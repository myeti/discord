<?php

namespace Discord\Orm\Query;

use Discord\Orm;

class Update extends Orm\Query
{

    use Clause\Where;

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