<?php

namespace App\Helper;

class Formatter
{
    public static function underscoreToCamelCaseFilter($string)
    {
        $camelCaseString = lcfirst(str_replace('_', '', ucwords($string, '_')));
        return $camelCaseString;
    }
}