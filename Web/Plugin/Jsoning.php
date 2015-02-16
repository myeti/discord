<?php

namespace Discord\Web\Plugin;

use Discord\Http;

class Jsoning
{

    /**
     * Handle response rendering
     *
     * @event kernel.respond
     *
     * @param Http\Request $request
     * @param $data
     *
     * @return Http\Response\Json
     */
    public function respond(Http\Request $request, $data)
    {
        return new Http\Response\Json($data);
    }

} 