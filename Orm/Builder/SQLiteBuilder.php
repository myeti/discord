<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Orm\Builder;

use Discord\Orm\Query;
use Discord\Orm\Builder;

class SQLiteBuilder extends Builder
{

    /** @var array */
    protected $queries = [
        'build' => SQLite\Query\CreateTable::class,
        'drop'  => Query\DropTable::class
    ];

}