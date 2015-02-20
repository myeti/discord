<?php

namespace Discord\Orm\Sql;

class Select extends Query
{

    use Clause\Where;
    use Clause\Sort;
    use Clause\Limit;

    /** @var array */
    protected $fields = [];


    /**
     * Set table
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
     * @param $fields
     * @return $this
     */
    public function select(...$fields)
    {
        $this->fields = $fields;
        return $this;
    }


    /**
     * Generate sql & values
     * @return array
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