<?php

namespace Noini\Optional\Interfaces;

interface Optional extends HasInterface, IfInterface, ThenInterface
{
    /**
     * Returns original payload content
     *
     * @return mixed
     */
    public function getPayload();
}