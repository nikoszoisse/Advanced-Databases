<?php

/**
 * Created by PhpStorm.
 * User: Nikos
 * Date: 5/16/2016
 * Time: 12:39 AM
 */
abstract class NzEnum
{
    final public function __construct($value)
    {
        $c = new ReflectionClass($this);
        if(!in_array($value, $c->getConstants())) {
            throw IllegalArgumentException();
        }
        $this->value = $value;
    }

    final public function __toString()
    {
        if(!is_string($this->value)){
            $this->value = "".$this->value;
        }
        return $this->value;
    }
}