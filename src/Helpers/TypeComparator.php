<?php

namespace Noini\Optional\Helpers;

trait TypeComparator
{
    /**
     * Compares if payload is certain type of Types class
     *
     * @param $payload
     * @param $expectedType
     * @return bool
     */
    protected function compareType($payload, $expectedType): bool
    {
        switch ($expectedType) {
            case Types::STRING:
                return is_string($payload);
            case Types::INTEGER:
                return is_int($payload);
            case Types::DOUBLE:
            case Types::FLOAT:
                return is_double($payload);
            case Types::CALLABLE:
                return is_callable($payload);
            case Types::BOOLEAN:
                return is_bool($payload);
            case Types::ARRAY:
                return is_array($payload);
            case Types::ITERABLE:
                return is_iterable($payload);
            case Types::OBJECT:
                return is_object($payload);
            case Types::RESOURCE:
                return is_resource($payload);
            case Types::NULL:
                return is_null($payload);
        }

        return false;
    }

    /**
     * Compares if given payload is instance of className
     *
     * @param $payload
     * @param $className
     * @return bool
     */
    protected function compareClass($payload, $className): bool
    {
        if (is_object($payload) && class_exists($className)) {
            return $payload instanceof $className;
        }

        return false;
    }
}