<?php

namespace Discord\Web\Service;

use Discord\Http;
use Discord\View;

class Rendering
{

    /** @var View\Viewable */
    protected $engine;


    /**
     * Rendering service
     *
     * @param View\Viewable $engine
     */
    public function __construct(View\Viewable $engine)
    {
        $this->engine = $engine;
    }


    /**
     * Handle response rendering
     *
     * @event kernel.response
     *
     * @param Http\Request $request
     * @param Http\Response $response
     *
     * @return Http\Response|null
     */
    public function kernelResponse(Http\Request $request, Http\Response $response)
    {



    }

}