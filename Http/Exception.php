<?php

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