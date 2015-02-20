<?php

namespace Discord\Orm;

class SQLite extends Mapper
{

    /**
     * SQLite driver connector
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        // create pdo instance
        $pdo = new \PDO('sqlite:' . $filename);
        parent::__construct($pdo);
    }


    /**
     * Build entity structure into database
     * @todo
     *
     * @return bool
     */
    public function build()
    {

    }

} 