<?php


namespace YiiMan\ApiStorm\Post;

use YiiMan\ApiStorm\Core\BaseObject;

/**
 * Class BasePostData
 * @package YiiMan\VirtualizorSdk\PostData
 */
abstract class BasePostData extends BaseObject implements BasePostDataInterface
{
    /**
     * serve data as array
     * @return array
     */
    public function serve()
    {
        $out = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            if (!isset($this->{$prop->name})) {
                continue;
            }

            $len = strlen($prop->name);
            $originalField = (string) substr($prop->name, 0, ($len - 1));


            $out[$originalField] = $this->{$prop->name};
        }

        return $out;
    }

    /**
     * @return bool
     */
    public function validated()
    {
        return $this->validated;
    }

    private function checkRequires()
    {
        $hasError = false;
        $reflection = new \ReflectionClass($this);
        $props = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $requires = [];
        foreach ($props as $prop) {
            $len = strlen($prop->name);
            $latestChar = (string) substr($prop->name, ($len - 1), 1);
            if ($latestChar == "0") {
                $requires[] = $prop->name;
            }
        }

        if (!empty($requires)) {
            foreach ($requires as $f) {
                if (!isset($this->{$f})) {
                    $this->addError($f, $f.' is required');
                    $hasError = true;
                }
            }
        }

        if ($hasError) {
            return false;
        }
        return true;
    }

    private function checkTypes()
    {
        $hasError = false;
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            if (!isset($this->{$prop->name})) {
                continue;
            }
            if (empty($this->rules()[$prop->name])) {
                continue;
            }
            $type = $this->rules()[$prop->name];

            if (is_callable($type)) {
                if ($this->{$prop->name} instanceof $type) {
                    $this->addError($prop->name, $prop.'should instant of class');
                    $hasError = true;
                }
            } else {
                $isOk = true;
                switch ($type) {
                    case 'integer':
                        $isOk = (is_int($this->{$prop->name}) | is_integer($this->{$prop->name})) ? true : false;
                        break;
                    case 'string':
                        $isOk = (is_string($this->{$prop->name})) ? true : false;
                        break;
                    case 'array':
                        $isOk = (is_array($this->{$prop->name})) ? true : false;
                        break;
                    case 'bool':
                    case 'boolean':
                        $isOk = (is_bool($this->{$prop->name})) ? true : false;
                        break;
                }

                if (!$isOk) {
                    $this->addError($prop->name, $prop->name.' type should be '.$type);
                    $hasError = true;
                }
            }
        }


        if ($hasError) {
            return false;
        } else {
            return true;
        }
    }

    public function validate(): bool
    {
        $reqs = $this->checkRequires();
        $types = $this->checkTypes();
        if ($reqs * $types) {
            return true;
        } else {
            return false;
        }
    }
}