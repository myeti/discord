<?php

namespace Discord\Http\Response;

use Discord\Http\Response;

class Json extends Response
{

    /**
     * New JSON Response
     *
     * @param string $content
     * @param int $code
     * @param array $headers
     */
    public function __construct($content = null, $code = 200, array $headers = [])
    {
        parent::__construct(json_encode($content, JSON_PRETTY_PRINT), $code, $headers);
        $this->format = 'application/json';
    }

} 