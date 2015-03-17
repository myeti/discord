<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
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
     * @event kernel.respond
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
            $content = $this->engine->render($template, (array)$data);

            return new Http\Response($content);
        }
    }

}