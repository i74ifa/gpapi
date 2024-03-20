<?php


namespace I74ifa\Gpapi\Helpers;
class InsteadOfMany
{
    public static function make($class, $classes)
    {
        foreach ($classes as $field) {
            if ($class instanceof $field) {
                return $class;
            }
        }
    }
}
