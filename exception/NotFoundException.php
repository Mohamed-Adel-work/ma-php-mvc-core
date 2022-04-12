<?php

/** User: MoAdel ... */

namespace app\core\exception;


/**
 * Class NotFoundException
 * 
 * @author Mohamed-Adel-work <mohamed.wemail@gmail.com>
 * @package app\core\exception
 */


class NotFoundException extends \Exception
{
    protected $message = "Page not found";
    protected $code = 404;
}