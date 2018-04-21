<?php

namespace Noini\Optional\Conditions;

use Noini\Optional\Interfaces\Optional;

class Otherwise
{
    /**
     * @var Optional
     */
    protected $optional;
    /**
     * @var bool
     */
    protected $hasResult;

    public function __construct(Optional $optional, bool $hasResult)
    {
        $this->optional = $optional;
        $this->hasResult = $hasResult;
    }

    /**
     * Executes callback if HAS method check was not successful.
     *
     * @param callable $callback
     * @return Optional
     */
    public function otherwise(callable $callback): Optional
    {
        if (!$this->hasResult) {
            call_user_func($callback, $this->optional->getPayload());
        }

        return $this->optional;
    }

}