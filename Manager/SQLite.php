<?php

namespace Discord\Orm\Manager;

use Discord\Orm\Manager;

class SQLite extends Manager
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