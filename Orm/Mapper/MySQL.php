<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Orm\Mapper;

use Discord\Orm\Mapper;
use Discord\Orm\Persister;

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
        $persister = new Persister($pdo);

        parent::__construct($persister);
    }

} 