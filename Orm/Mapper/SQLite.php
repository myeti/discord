<?php

namespace Discord\Orm\Mapper;

use Discord\Orm\Mapper;

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

} 