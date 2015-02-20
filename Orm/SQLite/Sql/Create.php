<?php

namespace Discord\Orm\SQLite\Sql;

use Discord\Orm\Sql;

class Create extends Sql\Create
{

    /** @var array */
    protected $syntax = [
        'primary'       => 'PRIMARY KEY AUTOINCREMENT',
        'null'          => 'NOT NULL',
        'default'       => 'DEFAULT',
    ];

} 