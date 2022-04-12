<?php

/** User: MoAdel */

namespace app\core\form;

use app\core\form\BaseFiled;

/**
 * Claas TextareaField
 * 
 * @author Mohamed-Adel-work <mohamed.wemail@gmail.com>
 * @package app\core\form
 */

class TextareaField extends BaseFiled
{
    public function renderInput(): string
    {
        return sprintf('<textarea name="%s" class="form-control%s">%s</textarea>',

            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute},
        );
    }
}