<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
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