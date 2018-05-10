<?php

namespace Noini\Optional\Conditions;

use Noini\Optional\Optional;

class Has extends Otherwise
{
    /**
     * @var Optional
     */
    protected $optional;

    public function __construct(Optional $optional, bool $hasResult = false)
    {
        parent::__construct($optional, $hasResult);
    }

    public function getResult(): bool
    {
        return $this->hasResult;
    }

    /**
     * Executes callback if HAS method was successful
     *
     * @param callable $callback
     * @return OtherwiseOptional
     */
    public function then(callable $callback): OtherwiseOptional
    {
        if($this->hasResult) {
            \call_user_func($callback, $this->optional->getPayload());
        }

        return new OtherwiseOptional($this->optional, $this->hasResult);
    }
}