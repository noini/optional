<?php

if (!function_exists("optional")) {
    function optional($payload): \Noini\Optional\Optional
    {
        return \Noini\Optional\Optional::create($payload);
    }
}