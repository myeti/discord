<?php

namespace Discord\View;

interface Viewable
{

    /**
     * Render template into viewable
     *
     * @param string $template
     * @param array $data
     *
     * @return mixed
     */
    public function render($template, array $data = []);

}