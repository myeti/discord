<?php

namespace Discord\Orm\Manager\SQLite;

use Discord\Orm\Query;

class Create extends Query\Create
{

    /** @var array */
    protected $syntax = [
        'primary'       => 'PRIMARY KEY AUTOINCREMENT',
        'null'          => 'NOT NULL',
        'default'       => 'DEFAULT',
    ];

} 