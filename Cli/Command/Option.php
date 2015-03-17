<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Cli\Command;

class Option extends Argument
{

    const NO_VALUE = 0;
    const MULTIPLE = 3;


    /**
     * New option
     * @param string $name
     * @param int $type
     */
    public function __construct($name, $type = self::OPTIONAL)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * No value
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->type === self::NO_VALUE);
    }

    /**
     * No has multiple values
     * @return bool
     */
    public function isMultiple()
    {
        return ($this->type === self::MULTIPLE);
    }

} 