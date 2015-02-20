<?php

namespace Discord\Orm;

class MySQL extends Mapper
{

    /**
     * MySQL driver constructor
     *
     * @param string $dbname
     * @param array $settings
     */
    public function __construct($dbname, array $settings = [])
    {
        // default settings
        $settings += [
            'host'      => 'localhost',
            'username'  => 'root',
            'password'  => null,
            'prefix'    => null
        ];

        // create pdo instance
        $connector = 'mysql:host=' . $settings['host'] . ';dbname=' . $dbname;
        $pdo = new \PDO($connector, $settings['username'], $settings['password']);

        // init db
        parent::__construct($pdo);
    }

} 