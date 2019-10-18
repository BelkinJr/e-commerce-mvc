<?php

namespace vbelkin\a3\controller;

/**
 * Class Controller
 *
 * @package veblkin/a3
 * @author  Vitaly Belkin <belkin.jr.nvk@gmail.com>
 */
class Controller
{
    /**
     * Redirect to another route
     *
     * @param $route
     * @param array $params
     */
    public function redirect($route, $params = [])
    {
        // Generate a redirect url for a given named route
        $url = $GLOBALS['router']->generate($route, $params);
        header("Location: $url");
    }
}
