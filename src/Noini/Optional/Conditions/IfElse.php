<?php
namespace Noini\Optional\Conditions;

use Noini\Optional\Interfaces\IfInterface;
use Noini\Optional\Optional;

class IfElse implements IfInterface
{
    /**
     * @var Optional
     */
    private $optional;
    /**
     * @var
     */
    private $lastResult = false;

    public function __construct(Optional $optional)
    {
        $this->optional = $optional;
    }

    /**
     * Will be executed if previous IF compare returned false.
     *
     * @param callable $callback
     * @return IfElse
     */
    public function else(callable $callback): IfElse
    {
        (new Otherwise($this->optional, $this->lastResult))->otherwise($callback);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function if($compare, callable $callback): IfElse
    {
        $has = $this->optional->has($compare);
        $this->lastResult = $has->getResult();
        $has->then($callback);

        return $this;
    }
}