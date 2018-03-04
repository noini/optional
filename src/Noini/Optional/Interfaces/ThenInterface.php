<?php

namespace Noini\Optional\Interfaces;

interface ThenInterface
{
    /**
     * Executes callback if payload is not null or
     * no previous has() method has been called.
     *
     * If has() have been previously called then last
     * result will be checked. Callback will executed
     * if has() result was successful.
     *
     * @param callable $callback
     * @return Optional
     */
    public function then(callable $callback): Optional;
}