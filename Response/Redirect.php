<?php

namespace Discord\Http\Response;

use Discord\Http\Response;

class Redirect extends Response
{

    /**
     * New Redirect Response
     *
     * @param string $url
     * @param int $code
     * @param array $headers
     */
    public function __construct($url, $code = 302, array $headers = [])
    {
        parent::__construct(null, $code, $headers);

        $this->header('Location', $url);
    }

} 