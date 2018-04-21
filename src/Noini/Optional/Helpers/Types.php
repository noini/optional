<?php

namespace Noini\Optional\Helpers;

/**
 * @package Noini\Optional\Helpers
 */
class Types
{
    public const STRING = '__STRING__';
    public const INTEGER = '__INTEGER__';
    public const DOUBLE = '__DOUBLE__';
    public const FLOAT = '__DOUBLE__';
    public const CALLABLE = '__CALLABLE__';
    public const BOOLEAN = '__BOOL__';
    public const ARRAY = '__ARRAY__';
    public const OBJECT = '__OBJECT__';
    public const RESOURCE = '__RESOURCE__';
    public const ITERABLE = '__ITERABLE__';
    public const NULL = '__NULL__';

    private function __construct($type)
    {
    }
}