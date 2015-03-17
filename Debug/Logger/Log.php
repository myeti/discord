<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Debug\Logger;

use Psr\Log\LogLevel;

class Log
{

    /** @var int */
    public $id;

    /** @var string datetime */
    public $date;

    /** @var string */
    public $level;

    /** @var string text */
    public $message;


    /**
     * New log
     * @param string $level
     * @param string $message
     */
    public function __construct($level, $message)
    {
        $this->date = date('Y-m-d H:i:s');
        $this->level = $level;
        $this->message = $message;
    }


    /**
     * Format log message
     * @return string
     */
    public function __toString()
    {
        $string = '[' . $this->date . '] ';
        if($this->level != LogLevel::INFO) {
            $string .= strtoupper($this->level) . ' : ';
        }
        $string .= $this->message;

        return $string;
    }

} 