<?php

namespace YiiMan\ApiStorm\Post;


interface BasePostDataInterface
{

    /**
     * this function validate your data based on defined rules and required fields
     * @return bool
     */
    public function validate(): bool;

    /**
     * define data type of every field like:
     *
     * [
     *  'fieldname'=>'int'|'string'|'float'|'array'|'object'|'class'|'boolean'
     * ]
     * @return array
     */
    public function rules():array;


}