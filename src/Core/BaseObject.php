<?php
/**
 * Copyright (c) 2021. YiiMan\apiStorm
 * Authors
 * info@yiiman.ir
 * https://yiiman.ir
 * develop@ariaservice.net
 * https://ariaservice.net
 ******************************************************************************/


namespace YiiMan\ApiStorm\Core;

/**
 * Class BaseObject
 * @package YiiMan\Core
 *
 */
class BaseObject
{
    protected $validated = true;
    protected $hasConnectionError = false;
    protected $errors = [];

    public function addError($prop, $error)
    {
        $this->errors[$prop] = $error;
    }

    public function hasConnectionError()
    {
        return $this->hasConnectionError;
    }

    public function errors(){
        return $this->errors;
    }
}