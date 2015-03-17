<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Http;

class Exception extends \Exception
{

    /** @var int */
    public $code = 418;


    /**
     * Force http code
     *
     * @param int $code
     * @param string $message
     */
    public function __construct($code, $message = null)
    {
        $this->code = $code;
        $this->message = $message;
    }

}