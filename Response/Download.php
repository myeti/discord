<?php

namespace Discord\Http\Response;

use Discord\Http\Response;

class Download extends Response
{

    /**
     * New Download Response
     *
     * @param string $filename
     * @param int $code
     * @param array $headers
     */
    public function __construct($filename, $code = 200, array $headers = [])
    {
        parent::__construct(file_get_contents($filename));

        $this->format = 'application/octet-stream';

        $this->header('Content-Transfer-Encoding', 'Binary');
        $this->header('Content-disposition', 'attachment; filename="' . basename($filename) . '"');
    }

} 