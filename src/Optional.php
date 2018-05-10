<?php

namespace Noini\Optional;

use Noini\Optional\Conditions\Has;
use Noini\Optional\Conditions\IfElse;
use Noini\Optional\Helpers\TypeComparator;
use Noini\Optional\Interfaces\Optional as OptionalInterface;

/**
 * @package Noini
 *
 * @todo Documentation
 * @todo Tests!
 */
class Optional implements OptionalInterface
{

    use TypeComparator;

    /** @var Payload $payload */
    protected $payload;

    /** @var Has $lastHas */
    protected $lastHas = null;

    public function __construct($payload)
    {
        $this->payload = new Payload($payload);

        return $this;
    }

    /**
     * Creates new instance of Optional
     *
     * @param $payload
     * @return Optional
     */
    public static function create($payload): Optional
    {
        return new Optional($payload);
    }

    /**
     * @inheritdoc
     */
    public function has($comparison): Has
    {
        if (is_callable($comparison)) {
            $result = call_user_func($comparison, $this->getPayload());
            if (!is_bool($result)) {
                throw new \UnexpectedValueException('Optional has() method expect callable to return bool value');
            }

            return $this->createStoredHas($result);
        }

        $hasPassed = $this->compareType($this->getPayload(), $comparison) ?:
            $this->compareClass($this->getPayload(), $comparison);

        if (!$hasPassed && $this->getPayload() === $comparison) {
            $hasPassed = true;
        }

        return $this->createStoredHas($hasPassed);
    }

    /**
     * @inheritdoc
     */
    public function then(callable $callback): OptionalInterface
    {
        if ($this->lastHas === null) {
            if (!$this->payload->isNull()) {
                call_user_func($callback, $this->getPayload());
            }
        } else {
            return $this->lastHas->then($callback);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function if($compare, callable $callback): IfElse
    {
        return IfElse::create($this)->if($compare, $callback);
    }

    /**
     * @inheritdoc
     */
    public function getPayload()
    {
        return $this->payload->getPayload();
    }

    private function createStoredHas(bool $hasPassed)
    {
        return $this->lastHas = new Has($this, $hasPassed);
    }
}