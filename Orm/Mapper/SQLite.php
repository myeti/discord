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