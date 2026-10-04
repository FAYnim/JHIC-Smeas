<?php

if (! function_exists('like_escape')) {
    function like_escape(string $value): string
    {
        return addcslashes($value, '\\%_');
    }
}
