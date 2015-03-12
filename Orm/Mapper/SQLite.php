<?php

namespace Discord\Orm\Mapper;

use Discord\Orm\Mapper;
use Discord\Orm\Persister;

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
        $persister = new Persister($pdo);

        parent::__construct($persister);
    }

} 