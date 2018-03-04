<?php
namespace Noini\Optional\Interfaces;

use Noini\Optional\Conditions\Has;

interface HasInterface
{
    /**
     * Checks if payload meets requirement
     *
     * @param callable|object|mixed $comparison
     * @return Has
     */
    public function has($comparison): Has;
}