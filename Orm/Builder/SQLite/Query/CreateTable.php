<?php

namespace Discord\Orm\Builder\SQlite\Query;

use Discord\Orm\Query;

class CreateTable extends Query\CreateTable
{

    /** @var array */
    protected $syntax = [
        'primary'       => 'PRIMARY KEY AUTOINCREMENT',
        'not-null'      => 'NOT NULL',
        'default'       => 'DEFAULT',
    ];

} 