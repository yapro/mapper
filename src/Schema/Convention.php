<?php

namespace Tarantool\Mapper\Schema;

use Tarantool\Mapper\Contracts;

class Convention implements Contracts\Convention
{
    public function getType($property)
    {
        if ($property == 'id') {
            return 'integer';
        }
        if (substr($property, -3) == '_at') {
            return 'integer';
        }

        return 'string';
    }

    public function getTarantoolType($type)
    {
        if ($type == 'string') {
            return 'STR';
        }

        return 'NUM';
    }

    public function isPrimitive($type)
    {
        return in_array($type, ['integer', 'string', 'array']);
    }

    public function encode($type, $value)
    {
        if (!$this->isPrimitive($type)) {
            if ($value instanceof Contracts\Entity) {
                return $value->getId();
            }

            return +$value;
        }

        if ($type == 'integer') {
            return +$value;
        }

        if (is_null($value)) {
            return;
        }

        if (!is_array($value)) {
            return "$value";
        }

        return $value;
    }

    public function decode($type, $value)
    {
        if ($type == 'integer') {
            return +$value;
        }

        return $value;
    }
}
