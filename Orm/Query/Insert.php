<?php

namespace Discord\Orm\Query;

class Insert implements Compilable
{

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

        $sql[] = 'INSERT INTO `' . $this->table . '`';

        $fields = $holders = [];
        foreach($this->data as $field => $value) {
            $fields[] = '`' . $field . '`';
            $holders[] = '?';
            $values[] = $value;
        }
        $sql[] = '(' . implode(', ', $fields) . ')';
        $sql[] = 'VALUES (' . implode(', ', $holders) . ')';

        $sql = implode("\n", $sql);

        return [$sql, $values];
    }

} 