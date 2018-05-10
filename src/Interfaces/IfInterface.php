<?php
namespace Noini\Optional\Interfaces;

use Noini\Optional\Conditions\IfElse;

interface IfInterface
{
    /**
     * Checks if payload meet requirement. Executes callback
     * if check was successful.
     *
     * @param $compare
     * @param callable $callback
     * @return IfElse
     */
    public function if($compare, callable $callback): IfElse;
}