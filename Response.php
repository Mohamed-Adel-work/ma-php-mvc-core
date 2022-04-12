<?php

/** User: MoAdel */

namespace app\core;

/**
 * Cllas Response
 * 
 * @author Mohamed-Adel-work <mohamed.wemail@gmail.com>
 * @package app\core
 */

class Response
{

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}
