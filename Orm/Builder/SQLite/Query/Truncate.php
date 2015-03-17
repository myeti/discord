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

class Truncate extends Query\Truncate
{

    /**
     * Generate sql & values
     * @return array [sql, values]
     */
    public function compile()
    {
        $sql =  'DELETE FROM `' . $this->table . '`;';

        return [$sql, []];
    }

} 