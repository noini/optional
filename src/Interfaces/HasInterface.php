<?php
namespace Noini\Optional\Interfaces;

use Noini\Optional\Conditions\Has;

interface HasInterface
{
    /**
     * Checks if payload meets requirement
     *
     * @param callable|mixed $comparison
     * @return Has
     */
    public function has($comparison): Has;
}