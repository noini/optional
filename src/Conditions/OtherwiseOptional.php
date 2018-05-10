<?php

namespace Noini\Optional\Conditions;

use Noini\Optional\Interfaces\Optional;

/**
 * @codeCoverageIgnore single line commands are not registered by Xdebug
 */
class OtherwiseOptional extends Otherwise implements Optional
{

    /**
     * @inheritdoc
     */
    public function has($comparison): Has
    {
        return $this->optional->has($comparison);
    }

    /**
     * @inheritdoc
     */
    public function if($compare, callable $callback): IfElse
    {
        return $this->optional->if($compare, $callback);
    }

    /**
     * @inheritdoc
     */
    public function then(callable $callback): Optional
    {
        return $this->optional->then($callback);
    }

    /**
     * @inheritdoc
     */
    public function getPayload()
    {
        return $this->optional->getPayload();
    }
}