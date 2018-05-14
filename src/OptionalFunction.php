<?php

if (!function_exists("optional")) {
    function optional($payload, callable $callback = null): \Noini\Optional\Optional
    {
        return \Noini\Optional\Optional::create($payload, $callback);
    }
}