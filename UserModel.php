<?php

/** User: MoAdel ... */

namespace app\core;
use app\core\db\DbModel;

/**
 * Class UserModel
 * 
 * @author Mohamed-Adel-work <mohamed.wemail@gmail.com>
 * @package app\core
 */

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
