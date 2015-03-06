<?php

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