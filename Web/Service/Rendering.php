<?php

namespace Discord\Web\Service;

use Discord\Web;
use Discord\Http;
use Discord\View;

class Rendering extends Web\Service
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
     * @param Http\Request $request
     * @param Http\Response $response
     *
     * @return Http\Response|null
     */
    public function after(Http\Request $request, Http\Response $response)
    {

    }

}