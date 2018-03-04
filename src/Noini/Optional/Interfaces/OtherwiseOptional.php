<?php

namespace Noini\Optional\Interfaces;

interface OtherwiseOptional extends Optional
{
    /**
     * Executes callback if previous HAS method check was not successful
     *
     * @param callable $callback
     * @return Optional
     */
    public function otherwise(callable $callback): Optional;
}