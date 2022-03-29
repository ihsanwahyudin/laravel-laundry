<?php

namespace App\Logging;

abstract class AllowedArrayLog
{
    public static function __callStatic($name, $arguments) {
        $numberOfArguments = count($arguments);
        if (method_exists(static::class, $function = $name.$numberOfArguments)) {
            return call_user_func_array(array(static::class, $function), $arguments);
        } else {
            throw new \BadMethodCallException(
                "Call to undefined method ".static::class."::{$name}()"
            );
        }
    }

    private static function filter1(array $context)
    {
        $exceptColumn = ['created_at', 'password', 'updated_at', 'deleted_at'];
        $allowedColumn = array_diff(array_keys($context), $exceptColumn);

        $arr = [];
        foreach($allowedColumn as $item) {
            $arr[$item] = $context[$item];
        }
        return $arr;
    }

    private static function filter2(array $context, string $comment)
    {
        $exceptColumn = ['created_at', 'password', 'updated_at', 'deleted_at'];
        $allowedColumn = array_diff(array_keys($context), $exceptColumn);

        $arr = [];
        foreach($allowedColumn as $item) {
            $arr[$item] = $context[$item];
        }
        $arr["comment"] = $comment;
        return $arr;
    }
}
