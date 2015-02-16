<?php

namespace Discord\Web\Plugin;

use Discord\Http;
use Discord\Web;
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
     * @param $data
     *
     * @return Http\Response|null
     */
    public function respond(Http\Request $request, $data)
    {
        // view response no compiled
        if(!empty($request->resource->context['render'])) {
            $template = $request->resource->context['render'];
            $content = $this->engine->render($template, $data);

            return new Http\Response($content);
        }
    }

}