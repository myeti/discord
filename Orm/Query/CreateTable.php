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

class CreateTable implements Compilable
{

    use Clause\Table;

    /** @var array */
    protected $fields = [];

    /** @var array */
    protected $syntax = [
        'primary'       => 'PRIMARY KEY AUTO_INCREMENT',
        'not-null'      => 'NOT NULL',
        'default'       => 'DEFAULT',
    ];

    /** @var array */
    protected $types = [
        'string'            => 'VARCHAR(255)',
        'string email'      => 'VARCHAR(255)',
        'string text'       => 'TEXT',
        'string date'       => 'DATE',
        'string datetime'   => 'DATETIME',
        'int'               => 'INTEGER',
        'bool'              => 'BOOLEAN',
    ];


    /**
     * Set field
     * @param string $field
     * @param string $type
     * @param bool $null
     * @param string $default
     * @return $this
     */
    public function set($field, $type = 'string', $null = true, $default = null, $primary = false)
    {
        $this->fields[$field] = [
            'type' => $type,
            'null' => $null,
            'default' => $default,
            'primary' => $primary
        ];

        return $this;
    }

    /**
     * Compile SQL
     *
     * @return array [sql, values]
     */
    public function compile()
    {
        // write create
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $this->table . '` (';

        // each field
        foreach($this->fields as $field => $opts) {

            // convert type
            $type = trim($opts['type']);
            $type = isset($this->types[$type])
                ? $this->types[$type]
                : 'VARCHAR(255)';

            // write field type
            $sql .= "\n" .  '`' . $field . '` ' . $type;

            // primary
            if($opts['primary'] == true) {
                $opts['null'] = false;
                $opts['default'] = null;
                $sql .= ' ' . $this->syntax['primary'];
            }

            // null
            if(!$opts['null']) {
                $sql .= ' ' . $this->syntax['not-null'];
            }

            // default
            if($opts['default']) {
                $sql .= ' ' . $this->syntax['default'] . ' ' . $opts['default'];
            }

            // end of line
            $sql .= ',';
        }

        // close sql
        $sql = trim($sql, ',') . "\n" . ');';

        return [$sql, []];
    }

}