<?php


namespace YiiMan\ApiStorm\Response;


use YiiMan\ApiStorm\Core\Res;

/**
 * Class BaseResponse
 * @package YiiMan\VirtualizorSdk\Responses
 */
class BaseResponse extends Res
{

    public function __construct(Res $data)
    {
        if ($data->isSuccess()) {
            $this->setSuccess();
            $this->parseSingle((array) $data->getData());
        } else {
            $this->setUnSuccess();
            $this->setError($data->getError()->errorCode, $data->getError()->message);
        }
    }


    private function getTypes($attr)
    {
        $types = explode('|', $this->{$attr});
        return $types;
    }

    private function parseSingle($data)
    {
        $reflector = new \ReflectionClass($this);
        $props = $reflector->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            $attr = $prop->name;
            $cls = $prop->class;
            $types = $this->getTypes($attr);
            foreach ($types as $type) {
                $this->setItem($type, $attr, $data);
            }
        }
    }

    private function setItem($type, $attr, $data)
    {
        $lowerType = strtolower($type);
        $isClass = substr($lowerType, 0, 6) === "class:";

        if ($isClass) {
            $className = str_replace('class:', '', $type);
            $className = str_replace('Class:', '', $className);
            $className = str_replace('CLASS:', '', $className);
            if (isset($data[$attr])) {
                $this->{$attr} = new $className($data[$attr]);
            } else {
                $this->{$attr} = new $className([]);
            }
            return;
        }


        $isClassArray = substr($lowerType, 0, 11) === "classarray:";
        if ($isClassArray) {
            $className = str_replace('classArray:', '', $type);
            $className = str_replace('ClassArray:', '', $className);
            $className = str_replace('Classarray:', '', $className);
            $className = str_replace('classarray:', '', $className);
            $className = str_replace('CLASSARRAY:', '', $className);
            if (isset($data[$attr])) {
                $out = [];
                foreach ($data[$attr] as $item) {
                    $out[] = new $className($item);
                }
                $this->{$attr} = $out;
            } else {
                $this->{$attr} = [];
            }
            return;
        }

        switch ($lowerType) {
            case 'int':
                if (isset($data[$attr])) {
                    $this->{$attr} = (int) $data[$attr];
                } else {
                    $this->{$attr} = 0;
                }
                break;
            case 'bool':
            case 'boolean':
                if (isset($data[$attr])) {
                    $this->{$attr} = (bool) $data[$attr];
                } else {
                    $this->{$attr} = 0;
                }
                break;

            case 'array':
                if (isset($data[$attr])) {
                    $this->{$attr} = (array) $data[$attr];
                } else {
                    $this->{$attr} = [];
                }
                break;
            case 'json':
                if (isset($data[$attr])) {
                    $this->{$attr} = json_decode($data[$attr]);
                } else {
                    $this->{$attr} = [];
                }
                break;
            case 'serialize':
                if (isset($data[$attr])) {
                    $this->{$attr} = unserialize($data[$attr]);
                } else {
                    $this->{$attr} = null;
                }
                break;
            case 'float':
                if (isset($data[$attr])) {
                    $this->{$attr} = (float) $data[$attr];
                } else {
                    $this->{$attr} = 0;
                }
                break;
            case 'string':
            default:
                if (isset($data[$attr])) {
                    $this->{$attr} = (string) $data[$attr];
                } else {
                    $this->{$attr} = '';
                }
                break;
        }
    }


}